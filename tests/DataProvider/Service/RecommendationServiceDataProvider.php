<?php

namespace App\Tests\DataProvider\Service;

use App\Entity\Movie;
use Generator;

class RecommendationServiceDataProvider
{
    public static function getRandomThree(): Generator
    {
        yield 'manyMoviesReturnsJustThree' => [
            'movies' => [
                new Movie('Movie One'),
                new Movie('Movie Two'),
                new Movie('Movie Three'),
                new Movie('Movie Four'),
                new Movie('Movie Five'),
            ],
            'expectedCount' => 3
        ];

        yield 'lessThanThreeReturnsAllMovies' => [
            'movies' => [
                new Movie('Movie One'),
                new Movie('Movie Two'),
            ],
            'expectedCount' => 2
        ];

        yield 'emptyMoviesListReturnsNoMovies' => [
            'movies' => [],
            'expectedCount' => 0
        ];
    }


    public static function getMoviesStartingWithWEven(): Generator
    {
        yield 'someShouldMatchSomeShouldNot' => [
            'movies' => [
                new Movie('Whiplash'),
                new Movie('Władca'),
                new Movie('Wyspa tajemnic'),
                new Movie('Władca Pierścieni'),
                new Movie('Matrix'),
            ],
            'shouldMatch' => [
                'Whiplash',       // W + 8 chars (even) - should match
                'Władca',         // W + 6 chars (even) - should match
                'Wyspa tajemnic', // W + 14 chars (even) - should match
            ],
            'shouldNotMatch' => [
                'Władca Pierścieni', // W + odd chars - should not match
                'Matrix',         // M - should not match (wrong letter)
            ]
        ];

        yield 'nothingShouldMatch' => [
            'movies' => [
                new Movie('Władca Pierścieni'),
                new Movie('Django'),
                new Movie('Matrix'),
            ],
            'shouldMatch' => [
            ],
            'shouldNotMatch' => [
                'Władca Pierścieni', // W + odd chars - should not match
                'Django',         // D - should not match (wrong letter)
                'Matrix',         // M - should not match (wrong letter)
            ]
        ];
    }


    public static function getMultiWordTitles(): Generator
    {
        yield 'someShouldMatchSomeShouldNot' => [
            'movies' => [
                new Movie('Pulp Fiction'),
                new Movie('Leon zawodowiec'),
                new Movie('Fight Club'),
                new Movie('Władca Pierścieni: Drużyna Pierścienia'),
                new Movie('Harry Potter i Kamień Filozoficzny'),
                new Movie('Matrix'),
                new Movie('Django'),
            ],
            'shouldMatch' => [
                'Pulp Fiction',      // 2 words - should match
                'Leon zawodowiec',   // 2 words - should match
                'Fight Club',        // 2 words - should match
                'Władca Pierścieni: Drużyna Pierścienia', // 4 words - should match
                'Harry Potter i Kamień Filozoficzny', // 5 words - should match
            ],
            'shouldNotMatch' => [
                'Matrix',            // 1 word - should not match
                'Django',            // 1 word - should not match
            ]
        ];
        yield 'noneShouldMatch' => [
            'movies' => [
                new Movie('Matrix'),
                new Movie('Django'),
            ],
            'shouldMatch' => [
            ],
            'shouldNotMatch' => [
                'Matrix',            // 1 word - should not match
                'Django',            // 1 word - should not match
            ]
        ];
    }

    public static function resultsAreMovieArrays(): Generator
    {
        yield [
            [
                new Movie('Pulp Fiction'),
                new Movie('Matrix'),
                new Movie('Whiplash'),
                new Movie('Wielki Gatsby'),
            ]
        ];
    }


}
