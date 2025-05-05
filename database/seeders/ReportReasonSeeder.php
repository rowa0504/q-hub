<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReportReason;

class ReportReasonSeeder extends Seeder
{
    private $reportReason;

    public function __construct(ReportReason $reportReason){
        $this->reportReason = $reportReason;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $report_reasons = [
            [
                'name' => 'Hate Speech or Symbols',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Nudity or Sexual Content',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Violence or Dangerous',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Scams or Fraud',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];

        $this->reportReason->insert($report_reasons);
    }
}
