<?php

declare(strict_types=1);

use Database\Factories\PatientFactory;
use function Pest\Laravel\putJson;

describe('update patient info', function (): void {
    it('successfully updates patient info', function (): void {
        $patient = PatientFactory::new()->createOne();

        putJson("/api/patients/{$patient->id}", [
            'name'                  => 'New Patient Name',
            'email'                 => 'updated@example.com',
            'password'              => 'TestPassword1!',
            'password_confirmation' => 'TestPassword1!',
        ])->assertOk()
            ->assertJsonPath('data.name', 'New Patient Name')
            ->assertJsonPath('data.email', 'updated@example.com');
    });

    it('fails when name is missing', function (): void {
        $patient = PatientFactory::new()->createOne();

        putJson("/api/patients/{$patient->id}", [
            'email'                 => 'test@example.com',
            'password'              => 'TestPassword1!',
            'password_confirmation' => 'TestPassword1!',
        ])->assertUnprocessable()
            ->assertJsonValidationErrorFor('name', 'error.fields');
    });

    it('fails when email is missing', function (): void {
        $patient = PatientFactory::new()->createOne();

        putJson("/api/patients/{$patient->id}", [
            'name'                  => 'Valid Name',
            'password'              => 'TestPassword1!',
            'password_confirmation' => 'TestPassword1!',
        ])->assertUnprocessable()
            ->assertJsonValidationErrorFor('email', 'error.fields');
    });

    it('fails when password is missing', function (): void {
        $patient = PatientFactory::new()->createOne();

        putJson("/api/patients/{$patient->id}", [
            'name'  => 'Valid Name',
            'email' => 'test@example.com',
        ])->assertUnprocessable()
            ->assertJsonValidationErrorFor('password', 'error.fields');
    });

    it('fails when name is shorter than 4 characters', function (): void {
        $patient = PatientFactory::new()->createOne();

        putJson("/api/patients/{$patient->id}", [
            'name'                  => 'abc',
            'email'                 => 'test@example.com',
            'password'              => 'TestPassword1!',
            'password_confirmation' => 'TestPassword1!',
        ])->assertUnprocessable()
            ->assertJsonValidationErrorFor('name', 'error.fields');
    });

    it('fails when name exceeds 100 characters', function (): void {
        $patient = PatientFactory::new()->createOne();

        putJson("/api/patients/{$patient->id}", [
            'name'                  => str_repeat('a', 101),
            'email'                 => 'test@example.com',
            'password'              => 'TestPassword1!',
            'password_confirmation' => 'TestPassword1!',
        ])->assertUnprocessable()
            ->assertJsonValidationErrorFor('name', 'error.fields');
    });

    it('fails when email is invalid', function (): void {
        $patient = PatientFactory::new()->createOne();

        putJson("/api/patients/{$patient->id}", [
            'name'                  => 'Valid Name',
            'email'                 => 'not-an-email',
            'password'              => 'TestPassword1!',
            'password_confirmation' => 'TestPassword1!',
        ])->assertUnprocessable()
            ->assertJsonValidationErrorFor('email', 'error.fields');
    });

    it('fails when password is not confirmed', function (): void {
        $patient = PatientFactory::new()->createOne();

        putJson("/api/patients/{$patient->id}", [
            'name'                  => 'Valid Name',
            'email'                 => 'test@example.com',
            'password'              => 'TestPassword1!',
            'password_confirmation' => 'DifferentPassword1!',
        ])->assertUnprocessable()
            ->assertJsonValidationErrorFor('password', 'error.fields');
    });
});
