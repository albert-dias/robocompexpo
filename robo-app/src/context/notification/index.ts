import { createState as createStateLink } from "@hookstate/core";

const isErrorRef = createStateLink(false);
const messageRef = createStateLink('');
const visibleRef = createStateLink(false);

export default {
    isErrorRef,
    messageRef,
    visibleRef,
}