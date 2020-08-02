<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserInfoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar_url')->comment('头像');
            $table->string('openid')->comment('微信用户唯一标识');
            $table->string('unionid')->comment('微信开放平台唯一标识符');
            $table->string('session_key')->comment('微信会话密钥');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar_url');
            $table->dropColumn('openid');
            $table->dropColumn('unionid');
            $table->dropColumn('session_key');
        });
    }
}
