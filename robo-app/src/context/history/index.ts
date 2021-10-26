import { createStateLink, useStateLinkUnmounted, useStateLink } from '@hookstate/core';

const nameMachineRef = createStateLink('');
const numberSerialRef = createStateLink('');
const problemRef = createStateLink('');
const descriptionRef = createStateLink('');
const suggestionRef = createStateLink('');

const clearForm = () => {
    useStateLinkUnmounted(nameMachineRef).set('');
    useStateLinkUnmounted(numberSerialRef).set('');
    useStateLinkUnmounted(problemRef).set('');
    useStateLinkUnmounted(descriptionRef).set('');
    useStateLinkUnmounted(suggestionRef).set('');
};

export default {
    nameMachineRef,
    numberSerialRef,
    problemRef,
    descriptionRef,
    suggestionRef,
    clearForm,
};