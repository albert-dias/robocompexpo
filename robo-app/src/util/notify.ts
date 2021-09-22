import GlobalContext from "../context";

const notify = (text: string, type: 'error' | 'success') => {
    const {
        notification: {
            isErrorRef,
            messageRef,
            visibleRef,
        },
    } = GlobalContext;

    const visible = visibleRef;
    const message = messageRef;
    const isError = isErrorRef;

    isError.set(type === 'error');
    message.set(text);
    visible.set(true);
};

export default notify;
