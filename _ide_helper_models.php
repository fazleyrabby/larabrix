<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $textarea
 * @property string|null $default_file_input
 * @property string|null $filepond_input
 * @property string|null $custom_select
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\CrudFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crud newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crud newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crud query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crud search($term)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crud whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crud whereCustomSelect($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crud whereDefaultFileInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crud whereFilepondInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crud whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crud whereTextarea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crud whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Crud whereUpdatedAt($value)
 */
	class Crud extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string|null $text
 * @property string|null $href
 * @property string|null $target
 * @property string $slug
 * @property int $parent_id
 * @property int $status
 * @property string|null $icon
 * @property string|null $image
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Menu> $children
 * @property-read int|null $children_count
 * @property-read Menu|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu search($term)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereHref($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu whereUpdatedAt($value)
 */
	class Menu extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $task_status_id
 * @property string $title
 * @property string|null $description
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TaskStatus $taskStatus
 * @method static \Database\Factories\TaskFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereTaskStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereUpdatedAt($value)
 */
	class Task extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @method static \Database\Factories\TaskStatusFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskStatus whereUpdatedAt($value)
 */
	class TaskStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

