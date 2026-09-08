<?php
declare(strict_types=1);

namespace BusinessUsers\Model\Entity;

use Cake\ORM\Entity;

/**
 * GroupMember Entity
 *
 * @property int $id
 * @property \Cake\I18n\DateTime $created
 * @property string|null $created_by
 * @property \Cake\I18n\DateTime $modified
 * @property string|null $modified_by
 * @property int $business_users_group_id
 * @property int $business_users_tenant_user_id
 *
 * @property \BusinessUsers\Model\Entity\Group $group
 * @property \BusinessUsers\Model\Entity\TenantUser $tenant_user
 */
class GroupMember extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        'business_users_group_id' => true,
        'business_users_tenant_user_id' => true,
        'group' => true,
        'tenant_user' => true,
    ];
}
