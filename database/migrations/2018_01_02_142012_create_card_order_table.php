<?php
use Illuminate\Support\Facades\Schema; use Illuminate\Database\Schema\Blueprint; use Illuminate\Database\Migrations\Migration; class CreateCardOrderTable extends Migration { public function up() { Schema::create('card_order', function (Blueprint $sp5bbfa0) { $sp5bbfa0->increments('id'); $sp5bbfa0->integer('order_id'); $sp5bbfa0->integer('card_id'); }); } public function down() { Schema::dropIfExists('card_order'); } }