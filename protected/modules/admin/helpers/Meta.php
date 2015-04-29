<?php
/**
 * Created by PhpStorm.
 * User: Ruslan
 * Date: 4/29/2015
 * Time: 3:30 PM
 */

class Meta {


    /**
    * Retrieve metadata from a file.
    *
    * Searches for metadata in the first 4kiB of a file, such as a plugin or theme.
    * Each piece of metadata must be on its own line. Fields can not span multiple
    * lines, the value will get cut at the end of the first line.
    *
    * If the file data is not within that first 8kiB, then the author should correct
    * their plugin file and move the data headers to the top.
    *
    * @param string $file            Path to the file.
    * @param array  $default_headers List of headers, in the format array('HeaderKey' => 'Header Name').
    * @param string $context         Optional. If specified adds filter hook "extra_{$context}_headers".
     *                                Default empty.
     * @return array Array of file headers in `HeaderKey => Header Value` format.
     */
     public static function get_file_data( $file, $default_headers, $context = '' ) {
        // We don't need to write to the file, so just open for reading.
        $fp = fopen( $file, 'r' );

        // Pull only the first 4kiB of the file in.
        $file_data = fread( $fp, 4096 );

        // PHP will close file handle, but we are good citizens.
        fclose( $fp );

        // Make sure we catch CR-only line endings.
        $file_data = str_replace( "\r", "\n", $file_data );

        /**
         * Filter extra file headers by context.
         *
         * The dynamic portion of the hook name, `$context`, refers to
         * the context where extra headers might be loaded.
         *
         * @since 2.9.0
         *
         * @param array $extra_context_headers Empty array by default.
         */
        if ( $context && $extra_headers = apply_filters( "extra_{$context}_headers", array() ) ) {
            $extra_headers = array_combine( $extra_headers, $extra_headers ); // keys equal values
            $all_headers = array_merge( $extra_headers, (array) $default_headers );
        } else {
            $all_headers = $default_headers;
        }

        foreach ( $all_headers as $field => $regex ) {
            if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1] )
                $all_headers[ $field ] =  $match[1];
            else
                $all_headers[ $field ] = '';
        }

        return $all_headers;
    }//get_file_data


}//end class