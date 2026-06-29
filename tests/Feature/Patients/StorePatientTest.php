<?php

declare(strict_types=1);

use Lightit\Patients\Domain\Models\Patient;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\postJson;

describe('store patient', function (): void {
    it('creates a new patient', function (): void {
        postJson(url('/api/patients'), [
            'name'                  => 'John Doe',
            'email'                 => 'john@example.com',
            'password'              => 'TestPassword1!',
            'password_confirmation' => 'TestPassword1!',
        ])->assertCreated();

        assertDatabaseCount(Patient::class, 1);
    });

    it('fails with empty patient data', function (): void {
        postJson(url('/api/patients'), [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'password'], 'error.fields');

        assertDatabaseCount(Patient::class, 0);
    });

    it('fails when name is shorter than 4 characters', function (): void {
        postJson(url('/api/patients'), [
            'name'                  => 'abc',
            'email'                 => 'test@example.com',
            'password'              => 'TestPassword1!',
            'password_confirmation' => 'TestPassword1!',
        ])->assertUnprocessable()
            ->assertJsonValidationErrorFor('name', 'error.fields');
    });

    it('fails when name exceeds 100 characters', function (): void {
        postJson(url('/api/patients'), [
            'name'                  => str_repeat('a', 101),
            'email'                 => 'test@example.com',
            'password'              => 'TestPassword1!',
            'password_confirmation' => 'TestPassword1!',
        ])->assertUnprocessable()
            ->assertJsonValidationErrorFor('name', 'error.fields');
    });

    it('fails when email is invalid', function (): void {
        postJson(url('/api/patients'), [
            'name'                  => 'John Doe',
            'email'                 => 'not-an-email',
            'password'              => 'TestPassword1!',
            'password_confirmation' => 'TestPassword1!',
        ])->assertUnprocessable()
            ->assertJsonValidationErrorFor('email', 'error.fields');
    });

    it('fails when password is not confirmed', function (): void {
        postJson(url('/api/patients'), [
            'name'                  => 'John Doe',
            'email'                 => 'john@example.com',
            'password'              => 'TestPassword1!',
            'password_confirmation' => 'DifferentPassword1!',
        ])->assertUnprocessable()
            ->assertJsonValidationErrorFor('password', 'error.fields');
    });
});
