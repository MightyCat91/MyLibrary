<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Author
 *
 * @property mixed id
 * @property int $id
 * @property string $name
 * @property string $biography
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property bool $moderate
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Book[] $books
 * @method static \Illuminate\Database\Query\Builder|\App\Author categories()
 * @method static \Illuminate\Database\Query\Builder|\App\Author series()
 * @method static \Illuminate\Database\Query\Builder|\App\Author whereBiography($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Author whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Author whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Author whereModerate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Author whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Author whereUpdatedAt($value)
 */
	class Author extends \Eloquent {}
}

namespace App{
/**
 * App\Book
 *
 * @property mixed id
 * @property int $id
 * @property string $description
 * @property int $page_counts
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $name
 * @property string|null $year
 * @property string|null $isbn
 * @property bool $moderate
 * @property float|null $average_rating
 * @property int|null $rating_quantity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Author[] $authors
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Categories[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Publisher[] $publishers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Series[] $series
 * @method static \Illuminate\Database\Query\Builder|\App\Book authorBooks()
 * @method static \Illuminate\Database\Query\Builder|\App\Book authorSeriesBooks()
 * @method static \Illuminate\Database\Query\Builder|\App\Book publisherSeriesBooks()
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereAverageRating($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereIsbn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereModerate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book wherePageCounts($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereRatingQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Book whereYear($value)
 */
	class Book extends \Eloquent {}
}

namespace App{
/**
 * App\Categories
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Book[] $books
 * @method static \Illuminate\Database\Query\Builder|\App\Categories authors()
 * @method static \Illuminate\Database\Query\Builder|\App\Categories whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Categories whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Categories whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Categories whereUpdatedAt($value)
 */
	class Categories extends \Eloquent {}
}

namespace App{
/**
 * App\Publisher
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Author[] $authors
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Book[] $books
 * @method static \Illuminate\Database\Query\Builder|\App\Publisher series()
 * @method static \Illuminate\Database\Query\Builder|\App\Publisher whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Publisher whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Publisher whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Publisher whereUpdatedAt($value)
 */
	class Publisher extends \Eloquent {}
}

namespace App{
/**
 * App\Series
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property bool $isPublisher
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Book[] $books
 * @method static \Illuminate\Database\Query\Builder|\App\Series addSeries($name)
 * @method static \Illuminate\Database\Query\Builder|\App\Series whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Series whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Series whereIsPublisher($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Series whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Series whereUpdatedAt($value)
 */
	class Series extends \Eloquent {}
}

namespace App{
/**
 * App\Status
 *
 * @property int $id
 * @property string $name
 * @property string $uname
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereUname($value)
 */
	class Status extends \Eloquent {}
}

