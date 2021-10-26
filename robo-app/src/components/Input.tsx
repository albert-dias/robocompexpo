import React from 'react';
import { TextInput } from 'react-native-paper';
import { StyleSheet } from 'react-native';
import theme from '../global/styles/theme';

const styles = StyleSheet.create({
    textInput: {
        backgroundColor: theme.colors.whitepure,
    },
});

interface InputProps {
    value: string;
    setValue: (value: string) => void;
}

const Input: React.FC<InputProps> = ({ value, setValue }) => (
    <TextInput
        style={styles.textInput}
        value={value}
        onChangeText={setValue}
        multiline
        numberOfLines={6}
        textAlignVertical='top'
    />
);

export default Input;