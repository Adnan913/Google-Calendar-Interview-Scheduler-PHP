<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('employer_id');
            $table->string('employer_email')->nullable();
            $table->text('access_token');
            $table->text('refresh_token');
            $table->string('token_type');
            $table->integer('expires_in');
            $table->integer('created');
            $table->boolean('is_expired')->default(false);
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
        Schema::dropIfExists('google_access_tokens');
    }
};
