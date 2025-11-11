<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Books;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BooksFactory extends Factory
{
    protected $model = Books::class;
    
    private static $books = [
        ['title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'description' => 'A gripping tale of racial injustice and childhood innocence in the American South during the 1930s.'],
        ['title' => '1984', 'author' => 'George Orwell', 'description' => 'A dystopian social science fiction novel exploring the dangers of totalitarianism and surveillance.'],
        ['title' => 'Pride and Prejudice', 'author' => 'Jane Austen', 'description' => 'A romantic novel of manners chronicling the relationship between Elizabeth Bennet and Mr. Darcy.'],
        ['title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald', 'description' => 'A tragic love story set in the Jazz Age exploring themes of decadence and the American Dream.'],
        ['title' => 'Harry Potter and the Philosopher\'s Stone', 'author' => 'J.K. Rowling', 'description' => 'The magical beginning of Harry Potter\'s journey at Hogwarts School of Witchcraft and Wizardry.'],
        ['title' => 'The Catcher in the Rye', 'author' => 'J.D. Salinger', 'description' => 'A coming-of-age story following teenager Holden Caulfield\'s experiences in New York City.'],
        ['title' => 'The Hobbit', 'author' => 'J.R.R. Tolkien', 'description' => 'The enchanting prelude to The Lord of the Rings, following Bilbo Baggins on an unexpected journey.'],
        ['title' => 'Brave New World', 'author' => 'Aldous Huxley', 'description' => 'A dystopian novel set in a futuristic World State where citizens are engineered through artificial reproduction.'],
        ['title' => 'The Lord of the Rings', 'author' => 'J.R.R. Tolkien', 'description' => 'An epic high-fantasy trilogy following the quest to destroy the One Ring and defeat the Dark Lord Sauron.'],
        ['title' => 'Animal Farm', 'author' => 'George Orwell', 'description' => 'A political allegory about a group of farm animals who rebel against their human farmer.'],
        ['title' => 'Jane Eyre', 'author' => 'Charlotte Brontë', 'description' => 'The story of an orphaned girl who becomes a governess and falls in love with her employer.'],
        ['title' => 'Moby-Dick', 'author' => 'Herman Melville', 'description' => 'Captain Ahab\'s obsessive quest to hunt the white whale that took his leg.'],
        ['title' => 'The Alchemist', 'author' => 'Paulo Coelho', 'description' => 'A philosophical novel about Santiago, a shepherd boy who dreams of finding treasure in Egypt.'],
        ['title' => 'Crime and Punishment', 'author' => 'Fyodor Dostoevsky', 'description' => 'A psychological thriller about a poor ex-student who murders a pawnbroker and struggles with guilt.'],
        ['title' => 'The Odyssey', 'author' => 'Homer', 'description' => 'An ancient Greek epic poem following Odysseus\'s ten-year journey home after the Trojan War.'],
    ];
    
    private static $index = 0;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $book = self::$books[self::$index % count(self::$books)];
        self::$index++;
        
        return [
            'title' => $book['title'],
            'author' => $book['author'],
            'description' => $book['description'],
            'status' => $this->faker->randomElement(['Available', 'Available', 'Available']),
            'max_slots' => 25,
            'reserved_today' => 0,
            'last_reset_date' => now()->toDateString(),
            'total_quantity' => 25,
            'available_quantity' => 25,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
