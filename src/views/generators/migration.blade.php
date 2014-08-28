<?php echo "<?php\n"; ?>

use Illuminate\Database\Migrations\Migration;

class AddBigcommerceToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Alters the {{ $table }} table
        Schema::table('{{ $table }}', function ($table) {
      		$table->integer('bigcommerce_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('{{ $table }}', function($table) {
        		$table->dropColumn(['bigcommerce_id']);
    		});
    }
}
