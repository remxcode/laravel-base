<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_auth', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('type')->default('')->comment('授权类型');
            $table->string('openid')->default('');
            $table->string('unionid')->default('')->comment('wechat unionid');
            $table->string('nickname')->default('')->comment('昵称');
            $table->string('name')->default('')->comment('姓名');
            $table->string('email')->default('')->comment('邮箱');
            $table->string('avatar')->default('')->comment('头像');
            $table->text('token');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_auth');
    }
}
