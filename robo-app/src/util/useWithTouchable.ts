import { StateRef, useStateLink } from '@hookstate/core';
import { useState } from 'react';

const useWithTouchable = <T>(ref: StateRef<T>) => {
  const state = useStateLink<T>(ref);
  const [touched, setTouched] = useState(false);
  const [blurred, setBlurred] = useState(false);

  const onBlur = () => setBlurred(true);

  const set = (v: T) => {
    if (touched === false) {
      setTouched(true);
    }
    if (blurred === true) {
      setBlurred(false);
    }
    state.set(v);
  };

  return {
    value: state.value,
    set,
    touched,
    blurred,
    onBlur,
  };
};

export default useWithTouchable;
