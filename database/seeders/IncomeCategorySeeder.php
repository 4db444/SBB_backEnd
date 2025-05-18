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
            [
                "name" => "Scholarships & Financial Aid",
                "children" => [
                    ["name" => "Scholarships"],
                    ["name" => "Grants"],
                    ["name" => "Government Financial Aid"],
                    ["name" => "University Stipends"],
                    ["name" => "Family Suport"],
                    ["name" => "Gifts"],
                ]
            ],
            [
                "name" => "Work & Jobs",
                "children" => [
                    ["name" => "Part-time Job"],
                    ["name" => "Freelance Income"],
                    ["name" => "Internship Stipend"],
                    ["name" => "On-campus Job"],
                ]
            ],
            [
                "name" => "Side Income",
                "children" => [
                    ['name' => "Selling Items"],
                    ['name' => "Side Hustles"],
                ]
            ],
            [
                "name" => "Withdrawals",
                "children" => [
                    ["name" => "Savings Withdrawal"],
                    ["name" => "Reimbursement"],
                ]
            ]
        ];

        foreach($income_categories as $income_category){
            $parent_category = IncomeCategory::create(["name" => $income_category['name']]);
            foreach($income_category["children"] as $child){
                $child_category = IncomeCategory::create($child);
                $child_category->parent()->associate($parent_category);
                $child_category->save();
            }
        }
    }
}
