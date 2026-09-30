<?php
declare(strict_types=1);

namespace BusinessUsers\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Psr\Http\Message\UploadedFileInterface;

/**
 * Stores each user's profile photo outside webroot and serves it to signed-in users.
 */
class ProfilePhotosController extends AppController
{
    private const MAX_BYTES = 2 * 1024 * 1024;
    private const MIME_EXTENSIONS = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    public function upload(): Response
    {
        $this->getRequest()->allowMethod('post');
        $identity = $this->getRequest()->getAttribute('identity');
        $userId = (string)($identity['id'] ?? '');
        if ($userId === '') {
            throw new ForbiddenException();
        }

        $returnUrl = ['plugin' => 'CakeDC/Users', 'prefix' => false, 'controller' => 'Users', 'action' => 'profile'];
        $uploaded = $this->getRequest()->getData('avatar_file');
        if (!$uploaded instanceof UploadedFileInterface || $uploaded->getError() !== UPLOAD_ERR_OK) {
            $this->Flash->error(__('Please select an image to upload.'));

            return $this->redirect($returnUrl);
        }

        $size = $uploaded->getSize();
        if ($size === null || $size < 1 || $size > self::MAX_BYTES) {
            $this->Flash->error(__('Profile photo must be smaller than 2 MB.'));

            return $this->redirect($returnUrl);
        }

        $stream = $uploaded->getStream();
        $stream->rewind();
        $bytes = $stream->read(self::MAX_BYTES + 1);
        if (strlen($bytes) !== $size || !$stream->eof()) {
            $this->Flash->error(__('Invalid profile photo size.'));

            return $this->redirect($returnUrl);
        }

        $mime = (new \finfo(FILEINFO_MIME_TYPE))->buffer($bytes);
        $dimensions = @getimagesizefromstring($bytes);
        if (!isset(self::MIME_EXTENSIONS[$mime]) || $dimensions === false ||
            $dimensions[0] > 4000 || $dimensions[1] > 4000) {
            $this->Flash->error(__('Use a JPEG, PNG, or WebP image up to 4000 pixels wide and high.'));

            return $this->redirect($returnUrl);
        }

        $users = $this->fetchTable('CakeDC/Users.Users');
        $user = $users->get($userId);
        $previous = (string)$user->get('avatar_path');
        $directory = ROOT . DS . 'data-files' . DS . 'BusinessUsers' . DS . 'avatars';
        if (!is_dir($directory) && !mkdir($directory, 0750, true) && !is_dir($directory)) {
            throw new \RuntimeException('Could not create the profile photo directory.');
        }
        $filename = bin2hex(random_bytes(16)) . '.' . self::MIME_EXTENSIONS[$mime];
        $path = $directory . DS . $filename;
        if (file_put_contents($path, $bytes, LOCK_EX) !== strlen($bytes)) {
            @unlink($path);
            throw new \RuntimeException('Could not store the profile photo.');
        }
        @chmod($path, 0640);

        $user->set('avatar_path', $filename);
        try {
            if (!$users->save($user)) {
                $this->Flash->error(__('Could not save the profile photo.'));
                @unlink($path);

                return $this->redirect($returnUrl);
            }
        } catch (\Throwable $exception) {
            @unlink($path);
            throw $exception;
        }

        if (preg_match('/^[a-f0-9]{32}\\.(?:jpg|png|webp)$/', $previous)) {
            @unlink($directory . DS . $previous);
        }
        $this->Flash->success(__('Profile photo updated.'));

        return $this->redirect($returnUrl);
    }

    public function view(string $id): Response
    {
        $this->getRequest()->allowMethod('get');
        if ($this->getRequest()->getAttribute('identity') === null) {
            throw new ForbiddenException();
        }
        try {
            $user = $this->fetchTable('CakeDC/Users.Users')->get($id);
        } catch (RecordNotFoundException) {
            throw new NotFoundException();
        }

        $filename = (string)$user->get('avatar_path');
        if (preg_match('/^[a-f0-9]{32}\\.(jpg|png|webp)$/', $filename, $matches)) {
            $path = ROOT . DS . 'data-files' . DS . 'BusinessUsers' . DS . 'avatars' . DS . $filename;
            if (is_file($path)) {
                $mime = ['jpg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'][$matches[1]];

                return $this->response->withFile($path)
                    ->withType($mime)
                    ->withHeader('Cache-Control', 'private, no-store')
                    ->withHeader('X-Content-Type-Options', 'nosniff');
            }
        }

        $label = trim((string)$user->get('first_name')) ?: (string)$user->get('email');
        $initial = htmlspecialchars(mb_strtoupper(mb_substr($label, 0, 1)), ENT_QUOTES, 'UTF-8');
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 96 96">'
            . '<rect width="96" height="96" rx="48" fill="#307ec5"/>'
            . '<text x="48" y="61" text-anchor="middle" font-family="sans-serif" font-size="38" fill="white">'
            . $initial . '</text></svg>';

        return $this->response->withType('image/svg+xml')
            ->withHeader('Cache-Control', 'private, no-store')
            ->withHeader('X-Content-Type-Options', 'nosniff')
            ->withStringBody($svg);
    }
}
