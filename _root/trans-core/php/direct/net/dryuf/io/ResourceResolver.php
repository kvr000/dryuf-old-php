<?php

namespace net\dryuf\io;


interface ResourceResolver
{
	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				COMPRESS_Unknown = -1;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				COMPRESS_Not = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				COMPRESS_Static = 1;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				COMPRESS_Dynamic = 2;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				COMPRESS_All = 3;

	/**
	 * Checks file type for the specified path.
	 * 
	 * @return -1
	 * 	if the path does not exist or is special device
	 * @return 0
	 * 	if the path is directory
	 * @return 1
	 * 	if the path is regular file
	 */
	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			checkFileType($path);

	/**
	 * Gets a resource as file data.
	 * 
	 * @return null
	 * 	if the resource cannot be found
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	function			getResource($path);

	/**
	 * Gets a resource as stream.
	 * 
	 * @return null
	 * 	if the resource cannot be found
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\io\InputStream')
	*/
	function			getResourceAsStream($path);

	/**
	 * Gets a resource as byte sequence.
	 * 
	 * @return null
	 * 	if the resource cannot be found
	 */
	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	function			getResourceContent($path);

	/**
	 * Gets list of entries in resource directory.
	 * 
	 * @return
	 * 	list of directory entries
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Collection<java\lang\String>')
	*/
	function			getResourcePaths($path);

	/**
	 * Gets a resource.
	 * 
	 * @return
	 * 	resource data
	 * 
	 * @throws IllegalArgumentException
	 * 	if the path is not found
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	function			getMandatoryResource($path);

	/**
	 * Gets a resource as stream.
	 * 
	 * @return
	 * 	resource stream
	 * 
	 * @throws IllegalArgumentException
	 * 	if the path is not found
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\io\InputStream')
	*/
	function			getMandatoryResourceAsStream($path);

	/**
	 * Gets content of resource.
	 * 
	 * @return
	 * 	resource content
	 * 
	 * @throws IllegalArgumentException
	 * 	if the path is not found
	 */
	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	function			getMandatoryResourceContent($path);

	/**
	 * Gets cache timeout for specific kind of resource.
	 * 
	 * @param resourceExtension
	 * 	file extension of resource name
	 * 
	 * @return cache timeout
	 * 	in case timeout applies
	 * @return -1
	 * 	in case caching not suitable
	 */
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	function			getCacheTimeout($resourceExtension);

	/**
	 * Gets compress policy for specific kind of resource.
	 * 
	 * @param resourceExtension
	 * 	file extension of resource name
	 * 
	 * @return COMPRESS_Unknown
	 * 	no special policy
	 * @return COMPRESS_Not
	 * 	if not compressable
	 * @return COMPRESS_Static
	 * 	compress static resources
	 * @return COMPRESS_Dynamic
	 * 	compress dynamic resources
	 * @return COMPRESS_All
	 * 	compress all resources
	 */
	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			getCompressPolicy($resourceExtension);
};


?>
