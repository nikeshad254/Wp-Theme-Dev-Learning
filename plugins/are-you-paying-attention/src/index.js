import { useEffect, useState } from "react";
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
} from "@wordpress/components";
import {
  InspectorControls,
  BlockControls,
  AlignmentToolbar,
  useBlockProps,
} from "@wordpress/block-editor";
import { ChromePicker } from "react-color";
import metadata from "./block.json";

wp.blocks.registerBlockType(metadata.name, { edit: EditComponent });

function EditComponent(props) {
  const [lockedSaveBtn, setLockedSaveBtn] = useState(false);

  useEffect(() => {
    const results = wp.data
      .select("core/block-editor")
      .getBlocks()
      .filter(function (block) {
        return (
          block.name === "ourplugin/are-you-paying-attention" &&
          block.attributes.correctAnswer === null
        );
      });

    if (results.length && !lockedSaveBtn) {
      setLockedSaveBtn(true);
      wp.data.dispatch("core/editor").lockPostSaving("noanswer");
    }

    if (!results.length && lockedSaveBtn) {
      setLockedSaveBtn(false);
      wp.data.dispatch("core/editor").unlockPostSaving("noanswer");
    }
  }, [props]);

  const blockProps = useBlockProps({
    className: "paying-attention-edit-block",
    style: { backgroundColor: props.attributes.bgColor },
  });

  function updateQuestion(value) {
    props.setAttributes({ question: value });
  }

  function deleteAnswer(indexToDelete) {
    const newAnswers = props.attributes.answers.filter(
      (_, idx) => idx !== indexToDelete
    );
    props.setAttributes({ answers: newAnswers });
    if (indexToDelete === props.attributes.correctAnswer)
      props.setAttributes({ correctAnswer: null });
  }

  function markAsCorrect(index) {
    props.setAttributes({ correctAnswer: index });
  }

  // what you will see in admin
  return (
    <div {...blockProps}>
      <BlockControls>
        <AlignmentToolbar
          value={props.attributes.theAlignment}
          onChange={(x) => props.setAttributes({ theAlignment: x })}
        />
      </BlockControls>
      <InspectorControls>
        <PanelBody title="Background Color" initialOpen={true}>
          <PanelRow>
            <ChromePicker
              color={props.attributes.bgColor}
              onChangeComplete={(x) => props.setAttributes({ bgColor: x.hex })}
              disableAlpha={true}
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
            <Button
              onClick={() => markAsCorrect(index)}
              className="mark-as-correct-container"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                className={
                  "size-6 " +
                  (props.attributes.correctAnswer === index
                    ? "fill"
                    : "no-fill")
                }
              >
                <path
                  fillRule="evenodd"
                  d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                  clipRule="evenodd"
                />
              </svg>
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
