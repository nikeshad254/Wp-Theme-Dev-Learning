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
      <TextControl label="Question:" />
      <p>Answers:</p>
      <Flex>
        <FlexBlock>
          <TextControl />
        </FlexBlock>
        <FlexItem>
          <Button>
            <Icon icon="star-empty" />
          </Button>
        </FlexItem>
        <FlexItem>
          <Button>Delete</Button>
        </FlexItem>
      </Flex>
    </div>
  );
}
