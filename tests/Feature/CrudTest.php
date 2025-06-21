<?php

use App\Models\Crud;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

beforeEach(function () {
    DB::table('cruds')->truncate();
    $this->crud = Crud::factory()->create();
    $this->user = User::find(1);
});

test('it can display the crud index', function () {
    $this->actingAs($this->user);
    $this->assertDatabaseHas('cruds', [
        'id' => $this->crud->id,
    ]);
    $response = get('admin/cruds');
    $response->assertViewIs('admin.cruds.index');
    $response->assertViewHas('cruds', function ($cruds) {
        return $cruds->contains('id', $this->crud->id);
    });
    $response->assertSee($this->crud->name);
});

test('it can create a crud', function () {
    $this->actingAs($this->user);

    $response = post('admin/cruds', [
        'title' => 'Test data',
        'textarea' => 'This is a text input',
        'custom_select' => 1,
    ]);

    $response->assertRedirect('/admin/cruds/create');

    $this->assertDatabaseHas('cruds', [
        'title' => 'Test data',
        'textarea' => 'This is a text input',
    ]);
});


test('it can update a crud', function () {
    $this->actingAs($this->user); // Act as the created user

    $response = put('admin/cruds/' . $this->crud->id, [
        'title' => 'Test data updated',
        'textarea' => 'This is a text input updated',
        'custom_select' => 2,
    ]);

    $response->assertRedirect('/admin/cruds');

    $this->assertDatabaseHas('cruds', [
        'title' => 'Test data updated',
        'textarea' => 'This is a text input updated',
        'custom_select' => 2,
    ]);
});


test('it can delete a crud', function () {
    $this->actingAs($this->user); // Act as the created user

    $this->assertDatabaseHas('cruds', [
        'id' => $this->crud->id,
    ]);

    $response = delete('admin/cruds/' . $this->crud->id);
    $response->assertRedirect('/admin/cruds');
    $this->assertDatabaseMissing('cruds', [
        'id' => $this->crud->id,
    ]);
});
