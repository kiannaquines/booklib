<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Books;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'description' => 'A gripping tale of racial injustice and childhood innocence in the American South during the 1930s. Through the eyes of young Scout Finch, this timeless classic explores themes of morality, compassion, and the loss of innocence.',
                'status' => 'Available',
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'description' => 'A dystopian social science fiction novel that explores the dangers of totalitarianism, surveillance, and the manipulation of truth. Set in a world of perpetual war and government oppression, Winston Smith struggles to maintain his humanity.',
                'status' => 'Available',
            ],
            [
                'title' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'description' => 'A romantic novel of manners that chronicles the relationship between Elizabeth Bennet and Mr. Darcy. This beloved classic explores themes of love, reputation, and class in Georgian England.',
                'status' => 'Available',
            ],
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'description' => 'A tragic love story set in the Jazz Age that explores themes of decadence, idealism, and the American Dream. The mysterious millionaire Jay Gatsby pursues his lost love in the glittering world of 1920s New York.',
                'status' => 'Available',
            ],
            [
                'title' => 'Harry Potter and the Philosopher\'s Stone',
                'author' => 'J.K. Rowling',
                'description' => 'The magical beginning of Harry Potter\'s journey at Hogwarts School of Witchcraft and Wizardry. An orphaned boy discovers he is a wizard and begins an adventure that will change his life forever.',
                'status' => 'Available',
            ],
            [
                'title' => 'The Catcher in the Rye',
                'author' => 'J.D. Salinger',
                'description' => 'A coming-of-age story following teenager Holden Caulfield\'s experiences in New York City. This controversial classic captures the angst and alienation of adolescence with unforgettable honesty.',
                'status' => 'Available',
            ],
            [
                'title' => 'The Hobbit',
                'author' => 'J.R.R. Tolkien',
                'description' => 'The enchanting prelude to The Lord of the Rings, following Bilbo Baggins on an unexpected journey with dwarves to reclaim their treasure from the dragon Smaug. A timeless tale of adventure and courage.',
                'status' => 'Available',
            ],
            [
                'title' => 'Brave New World',
                'author' => 'Aldous Huxley',
                'description' => 'A dystopian novel set in a futuristic World State where citizens are engineered through artificial reproduction and conditioning. It explores the price of stability, happiness, and technological progress.',
                'status' => 'Available',
            ],
            [
                'title' => 'The Lord of the Rings',
                'author' => 'J.R.R. Tolkien',
                'description' => 'An epic high-fantasy trilogy following the quest to destroy the One Ring and defeat the Dark Lord Sauron. This masterpiece of world-building follows hobbits, wizards, elves, and men in their struggle against evil.',
                'status' => 'Unavailable',
            ],
            [
                'title' => 'Animal Farm',
                'author' => 'George Orwell',
                'description' => 'A political allegory about a group of farm animals who rebel against their human farmer. This satirical novella reflects events leading up to the Russian Revolution and the Stalinist era of the Soviet Union.',
                'status' => 'Available',
            ],
            [
                'title' => 'The Chronicles of Narnia',
                'author' => 'C.S. Lewis',
                'description' => 'A series of seven fantasy novels set in the magical land of Narnia, where children embark on extraordinary adventures. These beloved stories explore themes of good versus evil, faith, and redemption.',
                'status' => 'Available',
            ],
            [
                'title' => 'Jane Eyre',
                'author' => 'Charlotte Brontë',
                'description' => 'The story of an orphaned girl who becomes a governess and falls in love with her employer, Mr. Rochester. A groundbreaking novel that explores independence, morality, and social class in Victorian England.',
                'status' => 'Available',
            ],
            [
                'title' => 'Moby-Dick',
                'author' => 'Herman Melville',
                'description' => 'Captain Ahab\'s obsessive quest to hunt the white whale that took his leg. This epic tale of adventure on the high seas explores themes of fate, nature, and the limits of human knowledge.',
                'status' => 'Available',
            ],
            [
                'title' => 'The Alchemist',
                'author' => 'Paulo Coelho',
                'description' => 'A philosophical novel about Santiago, a shepherd boy who dreams of finding treasure in Egypt. This inspiring tale teaches us to follow our dreams and listen to our hearts on the journey of self-discovery.',
                'status' => 'Available',
            ],
            [
                'title' => 'Fahrenheit 451',
                'author' => 'Ray Bradbury',
                'description' => 'A dystopian novel about a future American society where books are outlawed and "firemen" burn any that are found. It explores themes of censorship, technology, and the importance of literature.',
                'status' => 'Unavailable',
            ],
            [
                'title' => 'The Little Prince',
                'author' => 'Antoine de Saint-Exupéry',
                'description' => 'A poetic tale about a young prince who travels from planet to planet, learning life lessons along the way. This beloved novella explores themes of love, loss, and the importance of seeing with the heart.',
                'status' => 'Available',
            ],
            [
                'title' => 'Crime and Punishment',
                'author' => 'Fyodor Dostoevsky',
                'description' => 'A psychological thriller about a poor ex-student who murders a pawnbroker and struggles with guilt and paranoia. This masterpiece delves deep into the human psyche and moral philosophy.',
                'status' => 'Available',
            ],
            [
                'title' => 'The Diary of a Young Girl',
                'author' => 'Anne Frank',
                'description' => 'The poignant diary of a Jewish girl hiding from the Nazis during World War II. Anne Frank\'s words provide a powerful testament to the human spirit in the face of unimaginable horror.',
                'status' => 'Available',
            ],
            [
                'title' => 'The Odyssey',
                'author' => 'Homer',
                'description' => 'An ancient Greek epic poem following Odysseus\'s ten-year journey home after the Trojan War. This foundational work of Western literature is filled with adventure, mythology, and timeless wisdom.',
                'status' => 'Available',
            ],
            [
                'title' => 'Wuthering Heights',
                'author' => 'Emily Brontë',
                'description' => 'A passionate tale of love and revenge on the Yorkshire moors. The turbulent relationship between Heathcliff and Catherine Earnshaw spans generations in this Gothic masterpiece.',
                'status' => 'Available',
            ],
        ];

        foreach ($books as $book) {
            Books::create(array_merge($book, [
                'max_slots' => 25,
                'reserved_today' => 0,
                'last_reset_date' => now()->toDateString(),
            ]));
        }
    }
}
