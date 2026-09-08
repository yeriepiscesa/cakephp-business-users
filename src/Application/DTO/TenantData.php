<?php
declare(strict_types=1);

namespace BusinessUsers\Application\DTO;

/**
 * Immutable DTO carrying core Tenant information.
 */
final class TenantData
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $code,
        public readonly string $status,
        public readonly ?string $description,
        /** @var array<string, mixed> */
        public readonly array $settings,
    ) {}

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'status' => $this->status,
            'description' => $this->description,
            'settings' => $this->settings,
        ];
    }
}
