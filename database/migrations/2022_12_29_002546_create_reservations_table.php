<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attended_by');
            $table->unsignedBigInteger('client_id');
            $table->unsignedInteger('vehicle_type_id');
            $table->string('license_plate');
            $table->unsignedBigInteger('parking_place_id');
            $table->unsignedInteger('reservation_state_id')->default(1);
            $table->double('hour_price', 2);
            $table->double('total_paid', 2)->default(0);
            $table->timestamp('started_at');
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();

            $table->foreign('attended_by')->references('id')
            ->on('employees')->cascadeOnDelete();
            $table->foreign('client_id')->references('id')
            ->on('clients')->cascadeOnDelete();
            $table->foreign('parking_place_id')->references('id')
            ->on('parking_places')->cascadeOnDelete();
            $table->foreign('reservation_state_id')->references('id')
            ->on('reservation_states')->cascadeOnDelete();
            $table->foreign('vehicle_type_id')->references('id')
            ->on('vehicle_types')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
