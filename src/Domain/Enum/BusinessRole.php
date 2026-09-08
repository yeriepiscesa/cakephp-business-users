<?php
declare(strict_types=1);

namespace BusinessUsers\Domain\Enum;

/**
 * Canonical role codes for the `business_users_roles.code` column.
 *
 * Enum values are kept in sync with the seed data in
 * BusinessUsersTenantGroupRoleSeed so that `BusinessRole::tryFrom($role->code)`
 * resolves correctly for every seeded role.
 *
 * Hierarchy levels (lower = less privilege):
 *   Provider:  ProviderStaff(10) → ProviderSupervisor(20) → ProviderManager(30) → ProviderOwner(40)
 *   Agent:     AgentStaff(10) → AgentSupervisor(20) → AgentManager(30) → AgentOwner(40)
 *   End-user:  EndUser(10) → TravelCoordinator(20) → ApproverLevel1(30) → ApproverLevel2(40) → CorporateAdmin(50)
 */
enum BusinessRole: string
{
    // ─── Provider roles ───────────────────────────────────────────────────────

    /** Front-line provider operator. Level 10. */
    case ProviderStaff = 'provider-staff';

    /** Provider team supervisor. Level 20. */
    case ProviderSupervisor = 'provider-supervisor';

    /** Provider department manager. Level 30. */
    case ProviderManager = 'provider-manager';

    /** Provider tenant owner. Full control within the provider tenant. Level 40. */
    case ProviderOwner = 'provider-owner';

    // ─── Agent roles ──────────────────────────────────────────────────────────

    /** Front-line agent operator. Level 10. */
    case AgentStaff = 'agent-staff';

    /** Agent team supervisor. Level 20. */
    case AgentSupervisor = 'agent-supervisor';

    /** Agent department manager. Level 30. */
    case AgentManager = 'agent-manager';

    /** Agent tenant owner. Full control within the agent tenant. Level 40. */
    case AgentOwner = 'agent-owner';

    // ─── End-user / corporate travel roles ───────────────────────────────────

    /** Base traveller. Requests and purchases tickets. Level 10. */
    case EndUser = 'end-user';

    /** Travel desk coordinator. Liaises with the agent post-approval. Level 20. */
    case TravelCoordinator = 'travel-coordinator';

    /** First approval tier for standard travel requests. Level 30. */
    case ApproverLevel1 = 'approver-level-1';

    /** Second approval tier for high-value / policy exception requests. Level 40. */
    case ApproverLevel2 = 'approver-level-2';

    /** Owns travel policy; highest authority in a corporate tenant. Level 50. */
    case CorporateAdmin = 'corporate-admin';

    /**
     * Returns the hierarchy level for this role.
     * Higher value = higher privilege.
     */
    public function level(): int
    {
        return match ($this) {
            self::ProviderStaff, self::AgentStaff, self::EndUser => 10,
            self::ProviderSupervisor, self::AgentSupervisor, self::TravelCoordinator => 20,
            self::ProviderManager, self::AgentManager, self::ApproverLevel1 => 30,
            self::ProviderOwner, self::AgentOwner, self::ApproverLevel2 => 40,
            self::CorporateAdmin => 50,
        };
    }

    /**
     * Returns the human-readable label for the role.
     */
    public function label(): string
    {
        return match ($this) {
            self::ProviderStaff => 'Provider Staff',
            self::ProviderSupervisor => 'Provider Supervisor',
            self::ProviderManager => 'Provider Manager',
            self::ProviderOwner => 'Provider Owner',
            self::AgentStaff => 'Agent Staff',
            self::AgentSupervisor => 'Agent Supervisor',
            self::AgentManager => 'Agent Manager',
            self::AgentOwner => 'Agent Owner',
            self::EndUser => 'End User',
            self::TravelCoordinator => 'Travel Coordinator',
            self::ApproverLevel1 => 'Approver Level 1',
            self::ApproverLevel2 => 'Approver Level 2',
            self::CorporateAdmin => 'Corporate Admin',
        };
    }

    /**
     * Returns the tenant-type category this role belongs to.
     */
    public function tenantType(): string
    {
        return match ($this) {
            self::ProviderStaff, self::ProviderSupervisor,
            self::ProviderManager, self::ProviderOwner => 'provider',
            self::AgentStaff, self::AgentSupervisor,
            self::AgentManager, self::AgentOwner => 'agent',
            self::EndUser, self::TravelCoordinator,
            self::ApproverLevel1, self::ApproverLevel2,
            self::CorporateAdmin => 'end-user',
        };
    }

    /**
     * Returns all roles as an associative array [value => label] suitable
     * for use in select inputs.
     *
     * @return array<string, string>
     */
    public static function toOptions(): array
    {
        return array_column(
            array_map(
                fn(self $role) => ['value' => $role->value, 'label' => $role->label()],
                self::cases(),
            ),
            'label',
            'value',
        );
    }

    /**
     * Returns the roles grouped by tenant type.
     *
     * @return array<string, list<self>>
     */
    public static function grouped(): array
    {
        return [
            'provider' => [self::ProviderStaff, self::ProviderSupervisor, self::ProviderManager, self::ProviderOwner],
            'agent' => [self::AgentStaff, self::AgentSupervisor, self::AgentManager, self::AgentOwner],
            'end-user' => [self::EndUser, self::TravelCoordinator, self::ApproverLevel1, self::ApproverLevel2, self::CorporateAdmin],
        ];
    }
}
