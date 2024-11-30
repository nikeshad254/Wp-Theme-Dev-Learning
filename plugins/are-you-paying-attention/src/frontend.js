import React, { useEffect, useState } from "react";
import { createRoot } from "react-dom";
import "./frontend.scss";

const divsToUpdate = document.querySelectorAll(".paying-attention-update-me");

divsToUpdate.forEach((div) => {
  const data = JSON.parse(div.querySelector("pre").innerHTML);
  const root = createRoot(div);
  root.render(<Quiz {...data} />);
  div.classList.remove("paying-attention-update-me");
});

function Quiz(props) {
  const [isCorrect, setIsCorrect] = useState();
  const [isCorrectDelayed, setIsCorrectDelayed] = useState();

  function handleAnswer(index) {
    if (index == props.correctAnswer) {
      setIsCorrect(true);
    } else {
      setIsCorrect(false);
    }
  }

  useEffect(() => {
    if (isCorrect === false) {
      setTimeout(() => {
        setIsCorrect(undefined);
      }, 2600);
    }

    if (isCorrect === true) {
      setTimeout(() => {
        setIsCorrectDelayed(true);
      }, 1000);
    }
  }, [isCorrect]);

  return (
    <div
      className="paying-attention-frontend"
      style={{ backgroundColor: props.bgColor }}
    >
      <p>{props.question}</p>
      <ul>
        {props.answers.map(function (answer, index) {
          return (
            <li
              className={
                (isCorrectDelayed == true && index == props.correctAnswer
                  ? "no-click"
                  : "") +
                (isCorrectDelayed === true && index != props.correctAnswer
                  ? "fade-incorrect"
                  : "")
              }
              onClick={
                isCorrect === true ? undefined : () => handleAnswer(index)
              }
              key={index}
            >
              {isCorrectDelayed === true &&
                index == props.correctAnswer &&
                "✔️"}

              {isCorrectDelayed === true &&
                index != props.correctAnswer &&
                "❌"}
              {answer}
            </li>
          );
        })}
      </ul>

      <div
        className={
          "correct-message" +
          (isCorrect == true ? " correct-message--visible" : "")
        }
      >
        Correct Answer!
      </div>

      <div
        className={
          "incorrect-message" +
          (isCorrect === false ? " correct-message--visible" : "")
        }
      >
        Sorry, try again!
      </div>
    </div>
  );
}
