<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('mail_host')->nullable();
            $table->string('mail_port')->nullable();
            $table->string('mail_enctryption')->nullable();
            $table->string('mail_mailer')->nullable();
            $table->string('mail_username')->nullable();
            $table->string('mail_password')->nullable();
            $table->string('mail_mailfrom')->nullable();

            $table->string('google_client_id')->nullable();
            $table->string('google_client_secret')->nullable();
            $table->string('google_redirect_uri')->nullable();

            $table->string('facebook_client_id')->nullable();
            $table->string('facebook_client_secret')->nullable();
            $table->string('facebook_redirect_uri')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configs');
    }
};
