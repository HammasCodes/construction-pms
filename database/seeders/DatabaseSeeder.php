<?php

namespace Database\Seeders;

use App\Models\BoqItem;
use App\Models\Expense;
use App\Models\Project;
use App\Models\ProgressTask;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        foreach ($this->projects() as $data) {
            $project = Project::create($data['project']);

            foreach ($data['boq'] as $boq) {
                $project->boqItems()->create($boq);
            }

            foreach ($data['expenses'] as $expense) {
                $project->expenses()->create($expense);
            }

            foreach ($data['tasks'] as $task) {
                $project->progressTasks()->create($task);
            }
        }
    }

    private function projects(): array
    {
        return [
            [
                'project' => [
                    'name' => 'Skyline Residency Towers',
                    'client_name' => 'Greenfield Developers Pvt Ltd',
                    'location' => 'Whitefield, Bengaluru',
                    'type' => 'Residential',
                    'description' => 'Construction of two 18-storey residential towers with 240 apartments, clubhouse and basement parking.',
                    'start_date' => '2025-02-01',
                    'expected_completion_date' => '2027-01-31',
                    'status' => 'in_progress',
                    'estimated_budget' => 185000000,
                    'progress' => 42,
                ],
                'boq' => [
                    ['category' => 'Civil', 'description' => 'PCC 1:4:8 in foundation', 'unit' => 'm³', 'quantity' => 850, 'rate' => 4800, 'tax_percentage' => 18, 'remarks' => 'Foundation bed'],
                    ['category' => 'Civil', 'description' => 'RCC M30 for columns & slabs', 'unit' => 'm³', 'quantity' => 3200, 'rate' => 7200, 'tax_percentage' => 18, 'remarks' => 'Structural frame'],
                    ['category' => 'Steel', 'description' => 'TMT reinforcement steel Fe500', 'unit' => 'MT', 'quantity' => 480, 'rate' => 62000, 'tax_percentage' => 18, 'remarks' => null],
                    ['category' => 'Masonry', 'description' => 'AAC block wall 200mm', 'unit' => 'm²', 'quantity' => 14500, 'rate' => 950, 'tax_percentage' => 18, 'remarks' => 'External walls'],
                    ['category' => 'Finishing', 'description' => 'Vitrified tile flooring 600x600', 'unit' => 'm²', 'quantity' => 21000, 'rate' => 1250, 'tax_percentage' => 18, 'remarks' => 'Apartments'],
                ],
                'expenses' => [
                    ['type' => 'material', 'description' => 'OPC 53 grade cement', 'quantity' => 4200, 'unit' => 'bags', 'rate' => 410, 'date' => '2025-03-12', 'vendor' => 'UltraTech Dealer', 'remarks' => null],
                    ['type' => 'material', 'description' => 'TMT steel Fe500 delivery', 'quantity' => 120, 'unit' => 'MT', 'rate' => 61000, 'date' => '2025-04-05', 'vendor' => 'JSW Steel', 'remarks' => 'First lot'],
                    ['type' => 'labour', 'description' => 'Shuttering & centering crew', 'quantity' => 3200, 'unit' => 'man-days', 'rate' => 850, 'date' => '2025-05-20', 'vendor' => 'Sri Sai Contractors', 'remarks' => null],
                    ['type' => 'equipment', 'description' => 'Tower crane monthly rental', 'quantity' => 6, 'unit' => 'months', 'rate' => 350000, 'date' => '2025-06-01', 'vendor' => 'ACE Equipment', 'remarks' => null],
                    ['type' => 'other', 'description' => 'Site electricity & water', 'quantity' => 6, 'unit' => 'months', 'rate' => 85000, 'date' => '2025-06-30', 'vendor' => 'BESCOM / BWSSB', 'remarks' => 'Utilities'],
                ],
                'tasks' => [
                    ['milestone' => 'Foundation & Basement', 'planned_work' => 'Complete raft and basement RCC', 'completed_work' => 'Raft cast, basement walls done', 'completion_percentage' => 100, 'start_date' => '2025-02-01', 'due_date' => '2025-06-30', 'status' => 'completed', 'remarks' => 'On schedule'],
                    ['milestone' => 'Superstructure Tower A', 'planned_work' => 'Cast up to 18th floor slab', 'completed_work' => 'Up to 9th floor completed', 'completion_percentage' => 50, 'start_date' => '2025-07-01', 'due_date' => '2026-03-31', 'status' => 'in_progress', 'remarks' => null],
                    ['milestone' => 'MEP & Finishing', 'planned_work' => 'Electrical, plumbing, finishing', 'completed_work' => 'Not started', 'completion_percentage' => 0, 'start_date' => '2026-04-01', 'due_date' => '2027-01-15', 'status' => 'not_started', 'remarks' => null],
                ],
            ],
            [
                'project' => [
                    'name' => 'Metro Commercial Plaza',
                    'client_name' => 'Nakshatra Retail Holdings',
                    'location' => 'Baner, Pune',
                    'type' => 'Commercial',
                    'description' => 'A 6-floor commercial complex with retail podium, offices and multi-level car park.',
                    'start_date' => '2024-09-15',
                    'expected_completion_date' => '2026-06-30',
                    'status' => 'in_progress',
                    'estimated_budget' => 96000000,
                    'progress' => 68,
                ],
                'boq' => [
                    ['category' => 'Civil', 'description' => 'Excavation in ordinary soil', 'unit' => 'm³', 'quantity' => 9800, 'rate' => 220, 'tax_percentage' => 18, 'remarks' => 'Basement'],
                    ['category' => 'Civil', 'description' => 'RCC M35 structural concrete', 'unit' => 'm³', 'quantity' => 2100, 'rate' => 7600, 'tax_percentage' => 18, 'remarks' => null],
                    ['category' => 'Facade', 'description' => 'Structural glazing curtain wall', 'unit' => 'm²', 'quantity' => 3800, 'rate' => 4200, 'tax_percentage' => 18, 'remarks' => 'Front elevation'],
                    ['category' => 'MEP', 'description' => 'HVAC ducting & AHU', 'unit' => 'lot', 'quantity' => 1, 'rate' => 6800000, 'tax_percentage' => 18, 'remarks' => 'Central AC'],
                    ['category' => 'Finishing', 'description' => 'Granite cladding lobby', 'unit' => 'm²', 'quantity' => 1200, 'rate' => 2800, 'tax_percentage' => 18, 'remarks' => null],
                ],
                'expenses' => [
                    ['type' => 'material', 'description' => 'Ready-mix concrete M35', 'quantity' => 1400, 'unit' => 'm³', 'rate' => 6900, 'date' => '2024-11-10', 'vendor' => 'ACC RMC', 'remarks' => null],
                    ['type' => 'labour', 'description' => 'Structural steel fixing team', 'quantity' => 1800, 'unit' => 'man-days', 'rate' => 900, 'date' => '2025-01-15', 'vendor' => 'Deshmukh Labour Co', 'remarks' => null],
                    ['type' => 'material', 'description' => 'Curtain wall glass panels', 'quantity' => 2000, 'unit' => 'm²', 'rate' => 3900, 'date' => '2025-03-22', 'vendor' => 'Saint-Gobain', 'remarks' => 'Advance lot'],
                    ['type' => 'equipment', 'description' => 'Concrete boom pump hire', 'quantity' => 45, 'unit' => 'days', 'rate' => 28000, 'date' => '2025-02-08', 'vendor' => 'Schwing Stetter', 'remarks' => null],
                    ['type' => 'other', 'description' => 'Site safety & compliance', 'quantity' => 10, 'unit' => 'months', 'rate' => 65000, 'date' => '2025-04-30', 'vendor' => 'SafeSite Consultants', 'remarks' => null],
                ],
                'tasks' => [
                    ['milestone' => 'Substructure', 'planned_work' => 'Basement + podium slab', 'completed_work' => 'Completed and waterproofed', 'completion_percentage' => 100, 'start_date' => '2024-09-15', 'due_date' => '2025-02-28', 'status' => 'completed', 'remarks' => null],
                    ['milestone' => 'Superstructure', 'planned_work' => 'RCC frame up to terrace', 'completed_work' => 'All floors cast', 'completion_percentage' => 100, 'start_date' => '2025-03-01', 'due_date' => '2025-09-30', 'status' => 'completed', 'remarks' => 'Completed early'],
                    ['milestone' => 'Facade & Interiors', 'planned_work' => 'Glazing and fit-out', 'completed_work' => 'Glazing 60% done', 'completion_percentage' => 45, 'start_date' => '2025-10-01', 'due_date' => '2026-06-15', 'status' => 'in_progress', 'remarks' => null],
                ],
            ],
            [
                'project' => [
                    'name' => 'Riverside Villa Community',
                    'client_name' => 'Aqua Habitat LLP',
                    'location' => 'ECR, Chennai',
                    'type' => 'Residential Villas',
                    'description' => 'Gated community of 32 premium villas with landscaped gardens and shared amenities.',
                    'start_date' => '2025-06-01',
                    'expected_completion_date' => '2026-12-31',
                    'status' => 'pending',
                    'estimated_budget' => 74000000,
                    'progress' => 8,
                ],
                'boq' => [
                    ['category' => 'Civil', 'description' => 'Site grading & levelling', 'unit' => 'm²', 'quantity' => 18000, 'rate' => 180, 'tax_percentage' => 18, 'remarks' => 'Entire plot'],
                    ['category' => 'Civil', 'description' => 'Isolated footing RCC M25', 'unit' => 'm³', 'quantity' => 640, 'rate' => 6800, 'tax_percentage' => 18, 'remarks' => null],
                    ['category' => 'Masonry', 'description' => 'Red clay brick wall 230mm', 'unit' => 'm²', 'quantity' => 9600, 'rate' => 780, 'tax_percentage' => 18, 'remarks' => null],
                    ['category' => 'Roofing', 'description' => 'Sloped RCC roof with tiles', 'unit' => 'm²', 'quantity' => 5200, 'rate' => 2400, 'tax_percentage' => 18, 'remarks' => 'Villa roofs'],
                    ['category' => 'Landscape', 'description' => 'Garden & paver hardscape', 'unit' => 'm²', 'quantity' => 4200, 'rate' => 1100, 'tax_percentage' => 18, 'remarks' => 'Common area'],
                ],
                'expenses' => [
                    ['type' => 'equipment', 'description' => 'Excavator & JCB mobilisation', 'quantity' => 20, 'unit' => 'days', 'rate' => 18000, 'date' => '2025-06-10', 'vendor' => 'Coastal Earthmovers', 'remarks' => 'Site prep'],
                    ['type' => 'material', 'description' => 'M-sand & aggregates', 'quantity' => 900, 'unit' => 'm³', 'rate' => 1450, 'date' => '2025-06-25', 'vendor' => 'Bay Aggregates', 'remarks' => null],
                    ['type' => 'labour', 'description' => 'Foundation excavation crew', 'quantity' => 620, 'unit' => 'man-days', 'rate' => 780, 'date' => '2025-07-05', 'vendor' => 'Marina Labour Supply', 'remarks' => null],
                    ['type' => 'material', 'description' => 'Cement first consignment', 'quantity' => 1500, 'unit' => 'bags', 'rate' => 405, 'date' => '2025-07-12', 'vendor' => 'Ramco Cements', 'remarks' => null],
                    ['type' => 'other', 'description' => 'Approvals & survey charges', 'quantity' => 1, 'unit' => 'lot', 'rate' => 480000, 'date' => '2025-06-05', 'vendor' => 'CMDA / Surveyor', 'remarks' => 'Statutory'],
                ],
                'tasks' => [
                    ['milestone' => 'Land Development', 'planned_work' => 'Grading, roads, drainage', 'completed_work' => 'Grading in progress', 'completion_percentage' => 30, 'start_date' => '2025-06-01', 'due_date' => '2025-09-30', 'status' => 'in_progress', 'remarks' => 'Monsoon delays'],
                    ['milestone' => 'Villa Foundations', 'planned_work' => 'Footings for all 32 villas', 'completed_work' => 'Not started', 'completion_percentage' => 0, 'start_date' => '2025-10-01', 'due_date' => '2026-02-28', 'status' => 'not_started', 'remarks' => null],
                    ['milestone' => 'Amenities Block', 'planned_work' => 'Clubhouse & pool', 'completed_work' => 'Not started', 'completion_percentage' => 0, 'start_date' => '2026-03-01', 'due_date' => '2026-11-30', 'status' => 'not_started', 'remarks' => null],
                ],
            ],
        ];
    }
}
