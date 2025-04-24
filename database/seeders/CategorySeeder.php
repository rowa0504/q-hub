namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Food', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Travel', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Question', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Event', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Transportation', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Item', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Other', 'created_at' => now(), 'updated_at' => now()],
        ];

        // 💥 重複があってもエラーにならない神技
        Category::insertOrIgnore($categories);
    }
}
