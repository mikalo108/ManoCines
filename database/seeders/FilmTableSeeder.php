<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilmTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('films')->insert([
            [
                'name' => 'Inception',
                'image' => 'inception.webp',
                'overview' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a CEO.',
                'trailer' => 'https://www.youtube.com/embed/YoHD9XEInc0?si=wW07p0jbI2dwQKn9',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'The Matrix',
                'image' => 'matrix.webp',
                'overview' => 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.',
                'trailer' => 'https://www.youtube.com/embed/vKQi3bBA1y8?si=dUKDibAdKTt7NU0S',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Interstellar',
                'image' => 'interstellar.webp',
                'overview' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
                'trailer' => 'https://www.youtube.com/embed/zSWdZVtXT7E?si=pLCIgZgBERbppv96',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'The Dark Knight',
                'image' => 'dark_knight.webp',
                'overview' => 'When the menace known as the Joker emerges from his mysterious past, he wreaks havoc and chaos on the people of Gotham.',
                'trailer' => 'https://www.youtube.com/embed/EXeTwQWrcwY?si=00g2cyEK1lCy3eC4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pulp Fiction',
                'image' => 'pulp_fiction.webp',
                'overview' => 'The lives of two mob hitmen, a boxer, a gangster\'s wife, and a pair of diner bandits intertwine in four tales of violence and redemption.',
                'trailer' => 'https://www.youtube.com/embed/s7EdQ4FqbhY?si=QDwscBkuqOpP3Sr2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fight Club',
                'image' => 'fight_club.webp',
                'overview' => 'An insomniac office worker and a devil-may-care soap maker form an underground fight club that evolves into something much more.',
                'trailer' => 'https://www.youtube.com/embed/SUXWAEX2jlg?si=O0cdGMA4e_I-S2DQ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Forrest Gump',
                'image' => 'forrest_gump.webp',
                'overview' => 'The presidencies of Kennedy and Johnson, the Vietnam War, and other history unfold through the perspective of an Alabama man with an IQ of 75.',
                'trailer' => 'https://www.youtube.com/embed/bLvqoHBptjg?si=Cfw0UTeBIMqrn9pT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'The Shawshank Redemption',
                'image' => 'shawshank_redemption.webp',
                'overview' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
                'trailer' => 'https://www.youtube.com/embed/6hB3S9bIaco?si=NBOM_w_AxZ9y8ekJ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'The Godfather',
                'image' => 'godfather.webp',
                'overview' => 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.',
                'trailer' => 'https://www.youtube.com/embed/sY1S34973zA?si=e75jJDUPZIzS73qi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'The Lord of the Rings: The Fellowship of the Ring',
                'image' => 'lotr_fellowship.webp',
                'overview' => 'A meek Hobbit and eight companions set out on a journey to destroy the One Ring and save Middle-earth from the Dark Lord Sauron.',
                'trailer' => 'https://www.youtube.com/embed/V75dMMIW2B4?si=6LTEvSKUVX7RquQx',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gladiator',
                'image' => 'gladiator.webp',
                'overview' => 'A former Roman General sets out to exact vengeance against the corrupt emperor who murdered his family and sent him into slavery.',
                'trailer' => 'https://www.youtube.com/embed/owK1qxDselE?si=nYd0GhiaoZ8k2Bx-',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Titanic',
                'image' => 'titanic.webp',
                'overview' => 'A seventeen-year-old aristocrat falls in love with a kind but poor artist aboard the luxurious, ill-fated R.M.S. Titanic.',
                'trailer' => 'https://www.youtube.com/embed/kVrqfYjkTdQ?si=j70-717bWaOzTxaN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Avatar',
                'image' => 'avatar.webp',
                'overview' => 'A paraplegic Marine dispatched to the moon Pandora on a unique mission becomes torn between following his orders and protecting the world he feels is his home.',
                'trailer' => 'https://www.youtube.com/embed/5PSNL1qE6VY?si=K8pOx6i4BuonA5h3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jurassic Park',
                'image' => 'jurassic_park.webp',
                'overview' => 'During a preview tour, a theme park suffers a major power breakdown that allows its cloned dinosaur exhibits to run amok.',
                'trailer' => 'https://www.youtube.com/embed/lc0UehYemQA?si=UY0fJMhSqptKlKBV',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'The Avengers',
                'image' => 'avengers.webp',
                'overview' => 'Earth\'s mightiest heroes must come together and learn to fight as a team to stop the mischievous Loki and his alien army from enslaving humanity.',
                'trailer' => 'https://www.youtube.com/embed/eOrNdBpGMv8?si=RFL85EGF60eiXO4K',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
