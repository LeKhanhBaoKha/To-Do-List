import * as React from "react";
export default function RenderTimeLeft(todo) {
  if (todo.timeLeft == 0) {
    return (
      <>
        <p className="font-bold text-red-600 bg-red-50 rounded-lg text-center w-[80px] m-auto">
          Time&apos;s up
        </p>
      </>
    );
  } else {
    if (todo.timeLeft < 60) {
      return <>{todo.timeLeft} minutes</>;
    } else if (todo.timeLeft < 1440) {
      return (
        <>
          {Math.floor(todo.timeLeft / 60)} hours {todo.timeLeft % 60} minutes
        </>
      );
    } else {
      let days = Math.floor(todo.timeLeft / 1440);
      let minutesAfterDay = todo.timeLeft - days * 1440;
      let hours = Math.floor(minutesAfterDay / 60);
      let minutes = minutesAfterDay - hours * 60;

      const totalTimeLeft = [];
      if (days != 0) {
        totalTimeLeft.push(`${days} days`);
      }
      if (hours != 0) {
        totalTimeLeft.push(`${hours} hours`);
      }
      if (minutes != 0) {
        totalTimeLeft.push(`${minutes} minutes`);
      }
      return <>{totalTimeLeft.join(" ")}</>;
    }
  }
}
