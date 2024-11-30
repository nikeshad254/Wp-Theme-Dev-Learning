import "./index.scss";
import {
  TextControl,
  Flex,
  FlexBlock,
  FlexItem,
  Button,
  Icon,
} from "@wordpress/components";

// args: Short Name or Variable Names , Configuration Object
wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
  title: "Are You Paying Attention?",
  icon: "smiley",
  category: "Common",
  attributes: {
    skyColor: { type: "string" },
    grassColor: { type: "string" },
  },
  edit: EditComponent,
  save: function (props) {
    // what user will see on frontend
    return null;
  },
});

function EditComponent(props) {
  function updateSkyColor(e) {
    props.setAttributes({
      skyColor: e.target.value,
    });
  }

  function updateGrassColor(e) {
    props.setAttributes({
      grassColor: e.target.value,
    });
  }
  // what you will see in admin
  return (
    <div className="paying-attention-edit-block">
      <TextControl label="Question:" style={{ fontSize: "20px" }} />
      <p style={{ fontSize: "13px", margin: "20px 0 8px 0" }}>Answers:</p>
      <Flex>
        <FlexBlock>
          <TextControl />
        </FlexBlock>
        <FlexItem>
          <Button>
            <Icon icon="star-empty" className="mark-as-correct" />
          </Button>
        </FlexItem>
        <FlexItem>
          <Button isLink className="attention-delete">
            Delete
          </Button>
        </FlexItem>
      </Flex>

      <Button isPrimary>Add another answer</Button>
    </div>
  );
}
