export const registeredAcfBlocks = [];


export const layoutAttributes = {
	example: {
		type: 'string',
		meta: 'example',
		default: 'example'
	}
};

/**
 * Default attributes for specified blocks
 * @type {{slideshow: {container, alignment_vertical, items_break_point, columns, gutters, alignment_horizontal, fluid_items}}}
 */
const blockAttributes = {};

/**
 * Retrieve the attributes for given block
 * If there is not a block specified or the
 * key does not exist in the `blockAttributes`
 * object then the default attributes are returned
 *
 * @param block
 * @returns {*}
 */
export function getBlockConfig(block = null) {
	/**
	 *  if the block name is empty OR there are not custom attributes
	 *  return the default attributes
	 */
	if (!block || !(block in blockAttributes)) {
		return {
			hasExtraPanel: false,
			attributes: layoutAttributes
		};
	}
	return blockAttributes[block];
}
