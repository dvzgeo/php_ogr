/************************************************************************/
/*                                ogr2tab.php                           */
/************************************************************************/

-ogr2tab.php:  Read an OGR dataset and copy to a new OGR MapInfo dataset.

Example:  ./php -q ogr2tab.php 
          /path/to/outputfilename.tab 
          /path/to/sourcefilename.tab


/************************************************************************/
/*                                ogr2tab_spatialfilter.php             */
/************************************************************************/

-ogr2tab_spatialfilter.php:  A copy of ogr2tab.php to which the ability
 to set a spatial filter (bounding box search) has been added.

Note: the -spat and -where parameters are optional.

Example:  ./php -q ogr2tab_spatialfilter.php 
          /path/to/outputfilename.tab
          /path/to/sourcefilename.tab 
          -spat Xmin Ymin Xmax Ymax 
          -where "any_attribute <= a_certain_value"


/************************************************************************/
/*                                ogr2tab_sql.php                       */
/************************************************************************/

-ogr2tab_sql.php:  A copy of ogr2tab_spatialfilter.php to which the ability
 of setting a SQL attribute filter has been added.

Note: The -spat parameter is optional.  The -sql parameter is required.

Example:  ./php -q ogr2tab_sql.php 
          /path/to/outputfilename.tab
          /path/to/sourcefilename.tab 
          -spat Xmin Ymin Xmax Ymax
          -sql "SELECT any_attribute from layername 
                WHERE any_attribute < a_certain_value
                ORDER BY any_attribute ASC"


/************************************************************************/
/*                                ogr2tab_update.php                    */
/************************************************************************/

-ogr2tab_update.php:  A copy of ogr2tab.php that was modified to update
 the value of a specified attribute in a feature specified by
 feature id as it copies the features from the source to the
 destination.

Example:  ./php -q ogr2tab_update.php 
          /path/to/outputfilename.tab
          /path/to/sourcefilename.tab 
          -fid a_fid attribute_to_update new_attribute_value

/************************************************************************/
/*                                ogr_dump.php                          */
/************************************************************************/

-ogr_dump.php:  Dump the contents of an OGR data source. 
 Shows how to read feature and geometry members, attribute fields, etc.

Example:  ./php -q ogr_dump.php 
          /path/to/usr/sourcefilename

/************************************************************************/
/*                                ogr_write.php                         */
/************************************************************************/

-ogr_write.php:  Write various types of objects to a MapInfo file.  
 Shows how to create new features and geometries.

Example:  ./php -q ogr_write.php 
          /path/to/outputfilename

/************************************************************************/
/*                                ogr2ogr.php                           */
/************************************************************************/

-ogr2ogr.php:  Read an OGR dataset and copy to a new OGR dataset
 in specified format.

Example:  ./php -q ogr2ogr.php 
          /path/to/outputdirectory 
          /path/to/sourcedirectory 
          -f "MapInfo File" layername


/************************************************************************/
/*                                ogr_setgetfield.php                   */
/************************************************************************/

-ogr_setgetfield.php:  Test a few get/setField() operations that were
 not tested by other scripts, especially with attributes of list
 types.  Not pertinent for MapInfo datasets.

Example:  ./php -q ogr_setgetfield.php


/************************************************************************/
/*                                ogr_spatialfilter.php                 */
/************************************************************************/

-ogr_spatialfilter.php:  A copy of ogr2ogr.php to which the ability
 to set a spatial filter (bounding box search) has been added.

Example:  ./php -q ogr_spatialfilter.php 
          /path/to/outputdirectory
          /path/to/sourcedirectory -f "MapInfo File" 
          -spat Xmin Ymin Xmax Ymax -where "any_attribute <= a_certain_value"


/************************************************************************/
/*                                ogr_sql.php                           */
/************************************************************************/

-ogr_sql.php:  A copy of ogr_spatialfilter.php to which the ability
 of setting a SQL attribute filter has been added.

Example:  ./php -q ogr_sql.php 
          /path/to/outputdirectory
          /path/to/sourcedirectory 
          -f "MapInfo File" -spat Xmin Ymin Xmax Ymax
          -sql "SELECT any_attribute from layername 
          WHERE any_attribute < a_certain_value
          ORDER BY any_attribute ASC"



/************************************************************************/
/*                                ogr_update.php                        */
/************************************************************************/

-ogr_update.php:  A copy of ogr2ogr.php that was modified to update
 the value of a specified attribute in a feature specified by
 feature id as it copies the features from the source to the
 destination.

Example:  ./php -q ogr_update.php 
          /path/to/outputdirectory
          /path/to/sourcedirectory 
         -f "MapInfo File" layername 
         -fid a_fid attribute_to_update new_attribute_value
