import React, { useState } from "react";
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

  function handleAnswer(index) {
    if (index == props.correctAnswer) {
      setIsCorrect(true);
    } else {
      setIsCorrect(false);
    }
  }

  return (
    <div className="paying-attention-frontend">
      <p>{props.question}</p>
      <ul>
        {props.answers.map(function (answer, index) {
          return (
            <li onClick={() => handleAnswer(index)} key={index}>
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
