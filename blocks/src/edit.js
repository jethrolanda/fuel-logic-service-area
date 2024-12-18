import { store as coreDataStore } from "@wordpress/core-data";
import { useSelect } from "@wordpress/data";
import {
  TextareaControl,
  PanelBody,
  SelectControl,
  Spinner
} from "@wordpress/components";

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InspectorControls, useBlockProps } from "@wordpress/block-editor";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {Element} Element to render.
 */

function useCustomPatternBlocks(props) {
  const { patterns, hasResolved } = useSelect(
    (select) => {
      const selectorArgs = ["postType", "wp_block", { per_page: -1 }];

      return {
        patterns: select(coreDataStore).getEntityRecords(...selectorArgs),
        hasResolved: select(coreDataStore).hasFinishedResolution(
          "getEntityRecords",
          selectorArgs
        )
      };
    },
    [props]
  );

  return { patterns, hasResolved };
}

export default function Edit(props) {
  const { patterns, hasResolved } = useCustomPatternBlocks(props);
  const options = patterns
    ? patterns.map((p) => {
        return { value: p.id, label: p.title.raw };
      })
    : [];
  options.unshift({ value: "none", label: "Select a Pattern" });

  const blockProps = useBlockProps();

  const { attributes, setAttributes } = props;
  const {
    successMessagePattern,
    failMessagePattern,
    bannedMessagePattern,
    bannedStates
  } = attributes;

  function onChangeSuccessMessagePattern(value) {
    props.setAttributes({ successMessagePattern: value });
  }

  function onChangeFailMessagePattern(value) {
    setAttributes({ failMessagePattern: value });
  }

  function onChangeBannedMessagePattern(value) {
    setAttributes({ bannedMessagePattern: value });
  }

  function onChangeTextareaField(value) {
    setAttributes({ bannedStates: value });
  }

  return (
    <div class="fuel-logic-service-area-wrapper-class">
      <div {...blockProps}>
        {/* <BlockControls>
        <AlignmentToolbar
          value={props.attributes.theAlignment}
          onChange={(x) => props.setAttributes({ theAlignment: x })}
        />
      </BlockControls> */}
        <InspectorControls>
          <PanelBody title="Settings" initialOpen={true}>
            {hasResolved ? (
              <>
                <SelectControl
                  label="Success Message Pattern"
                  value={successMessagePattern}
                  options={options}
                  onChange={onChangeSuccessMessagePattern}
                />
                <SelectControl
                  label="Fail Message Pattern"
                  value={failMessagePattern}
                  options={options}
                  onChange={onChangeFailMessagePattern}
                />
                <SelectControl
                  label="Banned Message Pattern"
                  value={bannedMessagePattern}
                  options={options}
                  onChange={onChangeBannedMessagePattern}
                />
              </>
            ) : (
              <div style={{ marginBottom: "10px" }}>
                Loading Patterns
                <Spinner />
              </div>
            )}
            <TextareaControl
              label="Banned States"
              help="Enter name of states separated with comma. Ex: Hawaii, Alaska"
              value={bannedStates}
              onChange={(value) => onChangeTextareaField(value)}
            />
          </PanelBody>
        </InspectorControls>
        <div>
          <div class="flex gap-4 justify-center items-center mt-10 mb-10">
            <label for="name">Zip Code:</label>
            <input
              type="number"
              min="1"
              step="1"
              class="border-2 border-slate-400 rounded-md bg-white py-2 px-4 text-base text-gray-900 "
            />
            <button class="bg-lime-400 py-2 px-6 text-black rounded-md text-md">
              SUBMIT
            </button>
            <button
              class="text-sm text-red-600"
              data-wp-on--click="actions.clear"
            >
              Clear
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}
