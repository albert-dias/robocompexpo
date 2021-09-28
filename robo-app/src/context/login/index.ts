import { createState as createStateLink } from "@hookstate/core";

const cpfRef = createStateLink('');
const emailRef = createStateLink('');
const passwordRef = createStateLink('');
const userTypeRef = createStateLink('');

export default {
    cpfRef,
    emailRef,
    passwordRef,
    userTypeRef
};