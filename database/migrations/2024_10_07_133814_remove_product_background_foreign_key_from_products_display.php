    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */

        public function up()
        {
            Schema::table('products_display', function (Blueprint $table) {
                // Check if the foreign key exists before dropping
                if (Schema::hasColumn('products_display', 'product_background_id')) {
                    $table->dropForeign(['product_background_id']); // Ensure this matches the actual foreign key name
                }
            });
        }

        public function down()
        {
            Schema::table('products_display', function (Blueprint $table) {
                $table->foreign('product_background_id')->references('id')->on('products_background')->onDelete('cascade'); // Adjust as necessary
            });
        }
    };
