<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreateTableController extends Controller
{
    public function createAllTables() 
    {   
        // Tạo bảng addresses
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id'); 
            $table->string('street', 255)->nullable(); 
            $table->string('country', 255);
            $table->unsignedInteger('icon_id')->nullable(); 
            $table->unsignedInteger('monster_id');
            $table->timestamps();
        });

        // Tạo bảng articles
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id'); 
            $table->unsignedInteger('category_id'); 
            $table->string('title', 255);
            $table->string('slug', 255)->default('');
            $table->text('content');
            $table->string('image', 255)->nullable();
            $table->enum('status', ['PUBLISHED', 'DRAFT'])->default('PUBLISHED');
            $table->date('date');
            $table->boolean('featured')->default(0); 
            $table->timestamps(); 
            $table->softDeletes(); 
        });

        //Tạo bảng article_tag
        Schema::create('article_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();
            $table->softDeletes();
        });

        // a_s
        Schema::create('a_s', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('b_s_id');
        });
        // bills (engine MyISAM)
        Schema::create('bills', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->integer('id_customer')->nullable();
            $table->date('date_order')->nullable();
            $table->float('total')->nullable()->comment('tổng tiền');
            $table->string('payment', 200)->nullable()->comment('hình thức thanh toán');
            $table->string('note', 500)->nullable();
            $table->timestamps();
        });
        // payment
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bill_id');
            $table->string('payment_method', 100);
            $table->decimal('amount', 10, 2);
            $table->string('status', 50)->default('PENDING');
            $table->timestamps();
        
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade'); 
        });
        
        // bill_detail (engine MyISAM)
        Schema::create('bill_detail', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->integer('id_bill');
            $table->integer('id_product');
            $table->integer('quantity')->comment('số lượng');
            $table->double('unit_price');
            $table->timestamps();
        });

        // b_s
        Schema::create('b_s', function (Blueprint $table) {
            $table->increments('id');
            $table->string('data', 255);
        });

        // categories
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0);
            $table->unsignedInteger('lft')->nullable();
            $table->unsignedInteger('rgt')->nullable();
            $table->unsignedInteger('depth')->nullable();
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->timestamps();
            $table->softDeletes();
        });

        // comments
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 255);
            $table->text('comment');
            $table->unsignedInteger('id_product');
            $table->timestamps();
        });

        // customer (engine MyISAM)
        Schema::create('customer', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('name', 100);
            $table->string('gender', 10);
            $table->string('email', 50);
            $table->string('address', 100);
            $table->string('phone_number', 20);
            $table->string('note', 200);
            $table->timestamps();
        });

        // dummies
        Schema::create('dummies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->text('description');
            $table->longText('extras');
            $table->timestamps();
        });

        // failed_jobs
        if(!Schema::hasTable('failed_jobs')) {
            Schema::create('failed_jobs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->text('connection');
                $table->text('queue');
                $table->longText('payload');
                $table->longText('exception');
                $table->timestamp('failed_at')->useCurrent();
            });
        };

        // icons
        Schema::create('icons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('icon', 255);
            $table->timestamps();
        });

        // menu_items
        Schema::create('menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('type', 20)->nullable();
            $table->string('link', 255)->nullable();
            $table->unsignedInteger('page_id')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('lft')->nullable();
            $table->unsignedInteger('rgt')->nullable();
            $table->unsignedInteger('depth')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // migrations
        if(!Schema::hasTable('migrations')) {
            Schema::create('migrations', function (Blueprint $table) {
                $table->increments('id');
                $table->string('migration', 191);
                $table->integer('batch');
            });
        }

        // model_has_permissions
        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->string('model_type', 255);
            $table->unsignedBigInteger('model_id');
        });

        // model_has_roles
        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->string('model_type', 255);
            $table->unsignedBigInteger('model_id');
        });

        // monsters
        Schema::create('monsters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address', 255)->nullable();
            $table->string('browse', 255)->nullable();
            $table->boolean('checkbox')->nullable();
            $table->text('wysiwyg')->nullable();
            $table->string('color', 255)->nullable();
            $table->string('color_picker', 255)->nullable();
            $table->date('date')->nullable();
            $table->date('date_picker')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->dateTime('datetime')->nullable();
            $table->dateTime('datetime_picker')->nullable();
            $table->string('email', 255)->nullable();
            $table->integer('hidden')->nullable();
            $table->string('icon_picker', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('month', 255)->nullable();
            $table->integer('number')->nullable();
            $table->double('float', 8, 2)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('radio', 255)->nullable();
            $table->string('range', 255)->nullable();
            $table->integer('select')->nullable();
            $table->string('select_from_array', 255)->nullable();
            $table->integer('select2')->nullable();
            $table->string('select2_from_ajax', 255)->nullable();
            $table->string('select2_from_array', 255)->nullable();
            $table->text('simplemde')->nullable();
            $table->text('summernote')->nullable();
            $table->text('table')->nullable();
            $table->text('textarea')->nullable();
            $table->string('text', 255);
            $table->text('tinymce')->nullable();
            $table->string('upload', 255)->nullable();
            $table->string('upload_multiple', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->text('video')->nullable();
            $table->string('week', 255)->nullable();
            $table->text('extras')->nullable();
            $table->timestamps();
            $table->binary('base64_image')->nullable();
        });

        // monster_article
        Schema::create('monster_article', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('monster_id');
            $table->unsignedInteger('article_id');
            $table->timestamps();
            $table->softDeletes();
        });

        // monster_category
        Schema::create('monster_category', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('monster_id');
            $table->unsignedInteger('category_id');
            $table->timestamps();
            $table->softDeletes();
        });

        // monster_tag
        Schema::create('monster_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('monster_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();
            $table->softDeletes();
        });

        // news (engine MyISAM)
        Schema::create('news', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('title', 200)->comment('tiêu đề');
            $table->text('content')->comment('nội dung');
            $table->string('image', 100)->comment('hình');
            $table->timestamps();
            $table->softDeletes();
        });

        // pages
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('template', 255);
            $table->string('name', 255);
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->text('content')->nullable();
            $table->text('extras')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // password_resets
        if(!Schema::hasTable('password_resets')) {
            Schema::create('password_resets', function (Blueprint $table) {
                $table->string('email', 255);
                $table->string('token', 255);
                $table->timestamp('created_at')->useCurrent()->useCurrentOnUpdate();
            });
        };

        // permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('guard_name', 255);
            $table->timestamps();
        });

        // postalboxes
        Schema::create('postalboxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('postal_name', 255)->nullable();
            $table->integer('monster_id');
        });

        // products
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->nullable();
            $table->unsignedInteger('id_type')->nullable();
            $table->text('description')->nullable();
            $table->float('unit_price')->nullable();
            $table->float('promotion_price')->nullable();
            $table->string('image', 255)->nullable();
            $table->string('unit', 255)->nullable();
            $table->boolean('new')->default(0);
            $table->timestamps();
        });

        // revisions
        Schema::create('revisions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('revisionable_type', 255);
            $table->integer('revisionable_id');
            $table->integer('user_id')->nullable();
            $table->string('key', 255);
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->timestamps();
        });

        // roles
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('guard_name', 255);
            $table->timestamps();
        });

        // role_has_permissions
        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');
        });

        // settings
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 255);
            $table->string('name', 255);
            $table->string('description', 255)->nullable();
            $table->string('value', 255)->nullable();
            $table->text('field');
            $table->boolean('active');
            $table->timestamps();
        });

        // slide
        Schema::create('slide', function (Blueprint $table) {
            $table->increments('id');
            $table->string('link', 100);
            $table->string('image', 100);
        });

        // tags
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->timestamps();
            $table->softDeletes();
        });

        //type_products
        Schema::create('type_products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description');
            $table->string('image', 255);
            $table->timestamps();
        });

        //users
        if(!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        };

        //wishlists
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_product')->constrained('type_products')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
        return "Created all table successed";
    }
}
