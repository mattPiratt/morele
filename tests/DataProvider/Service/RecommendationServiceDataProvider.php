<?php

namespace App\Tests\DataProvider\Service;

use Generator;

class RecommendationServiceDataProvider
{
    public static function getRandomThree(): Generator
    {
        yield 'manyMoviesReturnsJustThree' => [
            'titles' => [
                'Movie One',
                'Movie Two',
                'Movie Three',
                'Movie Four',
                'Movie Five',
            ],
            'expectedCount' => 3
        ];

        yield 'lessThanThreeReturnsAllMovies' => [
            'titles' => [
                'Movie One',
                'Movie Two',
            ],
            'expectedCount' => 2
        ];

        yield 'emptyMoviesListReturnsNoMovies' => [
            'titles' => [],
            'expectedCount' => 0
        ];
    }


    public static function getMoviesStartingWithWEven(): Generator
    {
        yield 'someShouldMatchSomeShouldNot' => [
            'titles' => [
                'Whiplash',
                'Władca',
                'Wyspa tajemnic',
                'Władca Pierścieni',
                'Matrix',
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
            'titles' => [
                'Władca Pierścieni',
                'Django',
                'Matrix',
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
            'titles' => [
                'Pulp Fiction',
                'Leon zawodowiec',
                'Fight Club',
                'Władca Pierścieni: Drużyna Pierścienia',
                'Harry Potter i Kamień Filozoficzny',
                'Matrix',
                'Django',
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
            'titles' => [
                'Matrix',
                'Django',
            ],
            'shouldMatch' => [
            ],
            'shouldNotMatch' => [
                'Matrix',            // 1 word - should not match
                'Django',            // 1 word - should not match
            ]
        ];
    }

    public static function resultsAreStringArrays(): Generator
    {
        yield [
            [
                'Pulp Fiction',
                'Matrix',
                'Whiplash',
                'Wielki Gatsby',
            ]
        ];
    }


}
