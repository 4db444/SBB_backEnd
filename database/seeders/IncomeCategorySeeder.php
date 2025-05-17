<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IncomeCategory;

class IncomeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $income_categories = [
            ["name" => "Scholarships & Grants"],
            ["name" => "Student Loans"],
            ["name" => "Family Support"],
            ["name" => "Part-time Job / Freelance"],
            ["name" => "Internship Stipend"],
            ["name" => "Selling Items"],
            ["name" => "Gifts"],
            ["name" => "Side Hustles"],
            ["name" => "Savings Withdrawal"],
        ];

        foreach($income_categories as $income_category){
            IncomeCategory::create($income_category);
        };
    }
}
