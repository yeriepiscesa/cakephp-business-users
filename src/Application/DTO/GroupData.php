<?php
declare(strict_types=1);

namespace BusinessUsers\Application\DTO;

/**
 * Immutable DTO carrying core Group information.
 */
final class GroupData
{
    public function __construct(
        public readonly int $id,
        public readonly int $tenantId,
        public readonly string $name,
        public readonly string $code,
        public readonly ?string $description,
        public readonly bool $isDefault,
        public readonly bool $isActive,
        public readonly int $sortOrder,
    ) {}

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'tenant_id' => $this->tenantId,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'is_default' => $this->isDefault,
            'is_active' => $this->isActive,
            'sort_order' => $this->sortOrder,
        ];
    }
}
