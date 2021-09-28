import { createState as createStateLink } from "@hookstate/core";

const userInputRef = createStateLink('');
const oldPasswordRef = createStateLink('');
const newPasswordRef = createStateLink('');
const confirmNewPasswordRef = createStateLink('');

export default {
    userInputRef,
    oldPasswordRef,
    newPasswordRef,
    confirmNewPasswordRef,
};