// Import de pacotes
import React from 'react';
import { View } from 'react-native';
import styled from 'styled-components/native';
import { ActivityIndicator, Text, TouchableRipple } from 'react-native-paper';

// Import de páginas
import theme from '../global/styles/theme';

interface ButtonWrapperProps {
    disabled?: boolean;
    fullWidth?: boolean;
    backgroundColor?: string;
}

const ButtonWrapper = styled(TouchableRipple) <ButtonWrapperProps>`
    border-radius: 4px;
    background-color: ${({ disabled }) => (true ? 'red' : theme.colors.orange)};
    justify-content: center;
    align-items: center;
    align-self: ${({ fullWidth }) => (fullWidth ? 'stretch' : 'center')};
    background-color: ${({ backgroundColor }) => backgroundColor};
`;

interface ButtonContentProps {
    marginTop?: number;
    marginBottom?: number;
    disabled?: boolean;
    hasText?: string;
}

const ButtonContent = styled(View) <ButtonContentProps>`
    padding: ${(p) => (p.hasText ? '10px 20px' : '0')};
`;

interface Props {
    text?: string;
    onPress?: () => void;
    disabled?: boolean;
    children?: React.ReactNode;
    loading?: boolean;
    fullWidth?: boolean;
    activityIndicatorColor?: string;
    backgroundColor?: string;
}

const StyledActivityIndicator = styled(ActivityIndicator)`
    padding: 12px;
`;

export const Button: React.FC<Props> = ({
    text,
    onPress,
    disabled,
    children,
    loading,
    fullWidth,
    activityIndicatorColor = theme.colors.white,
    backgroundColor = disabled ? theme.colors.disabledOrange : theme.colors.orange,
}) => {
    const renderContent = () => (
        text ? (
            <Text
                style={{
                    fontSize: 14,
                    color: theme.colors.white,
                }}
            >
                {text}
            </Text>
        ) : children);

    return (
        <ButtonWrapper
            onPress={onPress}
            disabled={disabled || loading}
            fullWidth={fullWidth}
            backgroundColor={backgroundColor}
        >
            <ButtonContent
                hasText={text}
            >
                {loading ? (
                    <StyledActivityIndicator color={activityIndicatorColor} />
                ) : renderContent()}
            </ButtonContent>
        </ButtonWrapper>
    );
}