<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', static function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedInteger('status');
            $table->unsignedFloat('funds')->comment('in euro');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('blocked_at')->nullable();
            $table->timestamp('terminated_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
