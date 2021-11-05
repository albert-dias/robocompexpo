import { createStateLink } from "@hookstate/core";

const cpfRef = createStateLink('');
const passwordRef = createStateLink('');
const userTypeRef = createStateLink('');

export default {
    cpfRef,
    passwordRef,
    userTypeRef,
};