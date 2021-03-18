<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('level_role', ['admin', 'dokter', 'pasien'])->default('pasien');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('telp');
            $table->string('umur')->nullable();
            $table->date('ttl')->nullable();
            $table->string('alamat')->nullable();
            $table->enum('gender', ['perempuan', 'laki-laki'])->nullable();
            $table->string('image_profile')->nullable();
            $table->string('pengalaman')->nullable();
            $table->text('info')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->enum('status_akun', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
