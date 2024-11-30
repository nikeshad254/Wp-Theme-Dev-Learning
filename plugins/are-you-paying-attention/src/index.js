import "./index.scss";
import {
  TextControl,
  Flex,
  FlexBlock,
  FlexItem,
  Button,
  Icon,
  PanelBody,
  PanelRow,
  ColorPicker,
} from "@wordpress/components";
import { InspectorControls } from "@wordpress/block-editor";

(function () {
  let locked = false; // Move locked outside to maintain state across calls

  wp.data.subscribe(function () {
    // runs on any changes in the editors even hovers.
    const results = wp.data
      .select("core/block-editor")
      .getBlocks()
      .filter(function (block) {
        return (
          block.name === "ourplugin/are-you-paying-attention" &&
          block.attributes.correctAnswer === undefined
        );
      });

    if (results.length && !locked) {
      locked = true; // Set locked to true to prevent repeated calls
      wp.data.dispatch("core/editor").lockPostSaving("noanswer");
    }

    if (!results.length && locked) {
      locked = false; // Set locked to false to allow unlocking
      wp.data.dispatch("core/editor").unlockPostSaving("noanswer");
    }
  });
})();

// args: Short Name or Variable Names , Configuration Object
wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
  title: "Are You Paying Attention?",
  icon: "smiley",
  category: "Common",
  attributes: {
    question: { type: "string" },
    answers: {
      type: "array",
      default: [""],
    },
    correctAnswer: {
      type: "number",
      default: undefined,
    },
    bgColor: { type: "string", default: "#ebebeb" },
  },
  edit: EditComponent,
  save: function (props) {
    // what user will see on frontend
    return null;
  },
});

function EditComponent(props) {
  function updateQuestion(value) {
    props.setAttributes({ question: value });
  }

  function deleteAnswer(indexToDelete) {
    const newAnswers = props.attributes.answers.filter(
      (_, idx) => idx !== indexToDelete
    );
    props.setAttributes({ answers: newAnswers });
    if (indexToDelete === props.attributes.correctAnswer)
      props.setAttributes({ correctAnswer: undefined });
  }

  function markAsCorrect(index) {
    props.setAttributes({ correctAnswer: index });
  }

  // what you will see in admin
  return (
    <div
      className="paying-attention-edit-block"
      style={{ backgroundColor: props.attributes.bgColor }}
    >
      <InspectorControls>
        <PanelBody title="Background Color" initialOpen={true}>
          <PanelRow>
            <ColorPicker
              color={props.attributes.bgColor}
              onChangeComplete={(x) => props.setAttributes({ bgColor: x.hex })}
            />
          </PanelRow>
        </PanelBody>
      </InspectorControls>

      <TextControl
        label="Question:"
        value={props.attributes.question}
        onChange={updateQuestion}
        style={{ fontSize: "20px" }}
      />
      <p style={{ fontSize: "13px", margin: "20px 0 8px 0" }}>Answers:</p>

      {props.attributes.answers.map((answer, index) => (
        <Flex key={index}>
          <FlexBlock>
            <TextControl
              value={answer}
              onChange={(newValue) => {
                const newAnswers = props.attributes.answers.concat([]);
                newAnswers[index] = newValue;
                props.setAttributes({ answers: newAnswers });
              }}
            />
          </FlexBlock>
          <FlexItem>
            <Button onClick={() => markAsCorrect(index)}>
              <Icon
                icon={
                  props.attributes.correctAnswer === index
                    ? "star-filled"
                    : "star-empty"
                }
                className="mark-as-correct"
              />
            </Button>
          </FlexItem>
          <FlexItem>
            <Button
              isLink
              className="attention-delete"
              onClick={() => deleteAnswer(index)}
            >
              Delete
            </Button>
          </FlexItem>
        </Flex>
      ))}

      <Button
        isPrimary
        onClick={() => {
          props.setAttributes({
            answers: props.attributes.answers.concat([""]),
          });
        }}
      >
        Add another answer
      </Button>
    </div>
  );
}
