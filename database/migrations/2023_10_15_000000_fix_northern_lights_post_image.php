<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixNorthernLightsPostImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Find the Northern Lights post and update its image path
        DB::table('posts')
            ->where('title', 'like', '%Northern Lights%')
            ->orWhere('title', 'like', '%Aurora%')
            ->orWhere('title', 'like', '%Iceland%')
            ->update([
                'featured_image' => 'posts/northern-lights.jpg'
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No need to reverse this operation
    }
}