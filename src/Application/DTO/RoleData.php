<?php
declare(strict_types=1);

namespace BusinessUsers\Application\DTO;

use BusinessUsers\Domain\Enum\BusinessRole;

/**
 * Immutable data transfer object carrying Role information across layer boundaries.
 *
 * Constructed from ORM entities in the Infrastructure layer; consumed by the
 * Application layer and serialised to JSON by the Interface (Controller) layer.
 */
final class RoleData
{
    public function __construct(
        public readonly int $id,
        public readonly int $tenantId,
        public readonly string $name,
        public readonly string $code,
        public readonly int $level,
        public readonly ?string $description,
        public readonly bool $isDefault,
        public readonly bool $isActive,
        public readonly int $sortOrder,
        public readonly string $createdAt,
        public readonly string $modifiedAt,
    ) {}

    /**
     * Resolves the canonical BusinessRole enum case for this role's code.
     * Returns null when the code does not match a known canonical role.
     */
    public function canonicalRole(): ?BusinessRole
    {
        return BusinessRole::tryFrom($this->code);
    }

    /**
     * Serialises the DTO to a plain array suitable for JSON encoding.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $canonical = $this->canonicalRole();

        return [
            'id' => $this->id,
            'tenant_id' => $this->tenantId,
            'name' => $this->name,
            'code' => $this->code,
            'level' => $this->level,
            'description' => $this->description,
            'is_default' => $this->isDefault,
            'is_active' => $this->isActive,
            'sort_order' => $this->sortOrder,
            'canonical_code' => $canonical?->value,
            'created_at' => $this->createdAt,
            'modified_at' => $this->modifiedAt,
        ];
    }
}
