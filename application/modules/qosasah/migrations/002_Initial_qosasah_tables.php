<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 class Migration_Initial_qosasah_tables extends Migration {

    public function up()
    {
        $sql = array();

        // Snippets Table
        $sql[] = "CREATE TABLE bf_qosasah_snippets (
                id            INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                title 			VARCHAR(150) NOT NULL,
                description 	VARCHAR(1000),
                snippet 		VARCHAR(5000),
                created_by		INT(11) UNSIGNED NOT NULL,
                created_at	DATETIME,
                category	INT(11) UNSIGNED NOT NULL,
                private 		INT(11) UNSIGNED NOT NULL,
                url 		VARCHAR(200),
                PRIMARY KEY(id)
            );";

        // Category
        $sql[] = "CREATE Table bf_qosasah_categories (
                id            INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                name       VARCHAR(100) NOT NULL,
                PRIMARY KEY(id)
            );";

        // Bookmarks
        $sql[] = "CREATE TABLE bf_qosasah_bookmarks (
                user_id            INT(11) UNSIGNED NOT NULL,
                snippet_id 			INT(11) UNSIGNED NOT NULL,
                PRIMARY KEY(user_id, snippet_id)
            );";

        // Recommendation Table
        $sql[] = "CREATE TABLE bf_qosasah_recommendations (
                user_id            INT(11) UNSIGNED NOT NULL,
                snippet_id            INT(11) UNSIGNED NOT NULL,
                PRIMARY KEY(user_id, snippet_id)
            );";


        foreach ($sql as $s)
        {
            $this->db->query($s);
        }
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->dbforge->drop_table('bf_qosasah_snippets');
        $this->dbforge->drop_table('bf_qosasah_categories');
        $this->dbforge->drop_table('bf_qosasah_bookmarks');
        $this->dbforge->drop_table('bf_qosasah_recommendations');

    }

    //--------------------------------------------------------------------

}