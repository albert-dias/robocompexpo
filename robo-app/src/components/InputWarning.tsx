import React from 'react';
import { Text } from 'react-native';

interface InputWarningProps {
    text: string;
    valid: boolean;
    visible: boolean;
    textAlign?: 'left' | 'center';
}

export const InputWarning: React.FC<InputWarningProps> = ({
    text, valid, visible: touched, textAlign = 'left',
}) => (
    (touched && valid)
        ? (
            <Text
                style={{
                    marginTop: 5,
                    color: 'red',
                    textAlign,
                }}
            >
                {text}
            </Text>
        )
        : null
);