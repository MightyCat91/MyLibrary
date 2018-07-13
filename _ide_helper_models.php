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
 * @property array $rating
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Book[] $books
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereBiography($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereModerate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereUpdatedAt($value)
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
 * @property array $rating
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Author[] $authors
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Categories[] $categories
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Publisher[] $publishers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Series[] $series
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Book authorBooks()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Book authorSeriesBooks()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Book publisherSeriesBooks()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Book whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Book whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Book whereModerate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Book whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Book wherePageCounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Book whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Book whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Book whereYear($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Categories authors()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Categories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Categories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Categories whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Categories whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Publisher series()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Publisher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Publisher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Publisher whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Publisher whereUpdatedAt($value)
 */
	class Publisher extends \Eloquent {}
}

namespace App{
/**
 * App\Review
 *
 * @property int $id
 * @property int $book_id
 * @property int $user_id
 * @property string $text
 * @property array $rating
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Review whereUserId($value)
 */
	class Review extends \Eloquent {}
}

namespace App{
/**
 * App\Role
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series addSeries($name)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series whereIsPublisher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereUname($value)
 */
	class Status extends \Eloquent {}
}

