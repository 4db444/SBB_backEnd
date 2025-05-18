<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;

class ExpenseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $expense_categories = [
            [
                "name" => "Education",
                "children" => [
                    ["name" => "Tuition Fees"],
                    ["name" => "Books & Supplies"],
                    ["name" => "Online Courses / Subscriptions"],
                    ["name" => "Exam Fees"],
                    ["name" => "Printing / Copying"],
                ]
            ],
            [
                "name" => "Housing",
                "children" => [
                    ["name" => "Rent"],
                    ["name" => "Utilities"],
                    ["name" => "Maintenance"],
                    ["name" => "Cleaning Products & Supplies"],
                ]
            ],
            [
                "name" => "Food",
                "children" => [
                    ["name" => "Groceries"],
                    ["name" => "Takeout"],
                    ["name" => "Snacks"],
                ]
            ],
            [
                "name" => "Transportation",
                "children" => [
                    ["name" => "Public Transport"],
                    ["name" => "Fuel"],
                    ["name" => "Vehicle Maintenance"],
                ]
            ],
            [
                "name" => "Tech & Subscriptions",
                "children" => [
                    ["name" => "Phone Bill"],
                    ["name" => "Online Subscriptions"],
                    ["name" => "Software Licenses"],
                ]
            ],
            [
                "name" => "Personal Care",
                "children" => [
                    ["name" => "Clothes / Shoes"],
                    ["name" => "Haircuts / Grooming"],
                    ["name" => "Toiletries"],
                ]
            ],
            [
                "name" => "Health",
                "children" => [
                    ["name" => "Health Insurance"],
                    ["name" => "Medications"],
                    ["name" => "Doctor / Dentist Visits"],
                    ["name" => "Gym Membership"],
                ]  
            ],
            [
                "name" => "Entertainment",
                "children" => [
                    ["name" => "Going Out"],
                    ["name" => "Movie"],
                    ["name" => "Event"],
                    ["name" => "Hobbie"],
                    ["name" => "Game"],
                ]
            ],
            [
                "name" => "Financial",
                "children" => [
                    ["name" => "Loan Repayment"],
                    ["name" => "Credit Card Payments"],
                    ["name" => "Transaction Fees"],
                ]
            ],
        ];

        foreach($expense_categories as $expense_category){
            $parent_category = ExpenseCategory::create(["name" => $expense_category["name"]]);
            foreach($expense_category["children"] as $child){
                $child_category = ExpenseCategory::create($child);
                $child_category->parent()->associate($parent_category);
                $child_category->save();
            }
        }
    }
}