import { View } from "react-native";
import { IconButton, Title, Text, TextInput } from "react-native-paper";
import styled from "styled-components/native";

import theme from "../global/styles/theme";

interface InputProps {
    width?: string;
}
interface StyledIconWrapper {
    active: boolean;
}
interface StyledIconButtonProps {
    active: boolean;
}

export const BottomNav = styled(View)`
    height: 70px;
    background-color: ${theme.colors.surface};
    flex-direction: row;
    align-items: center;
    width: 100%;
    justify-content: center;
`;

export const ButtonClose = styled.TouchableOpacity`
    width: 40px;
    height: 40px;
    align-items: center;
    justify-content: center;
    position: absolute;
    margin-top: 5px;
    right: 0;
    margin-right: 5px;
`;

export const ButtonSelect = styled.TouchableOpacity`
    width: 100%;
    background-color: ${({ theme }) => theme.colors.surface};
    align-items: center;
    padding: 12px;
    border-radius: 5px;
    flex-direction: row;
    margin-top: 16px;
`;

export const ContentModal = styled.View`
    background-color: rgba(0,0,0,0.5);
    flex: 1;
    justify-content: center;
    align-items: center;
    margin-top: 22px;
`;

export const GroupControl = styled(View)`
    padding: 10px;
    width: 100%;
`;

export const Input = styled(TextInput) <InputProps>`
    width: ${({ width }) => width ?? '100%'};
    height: 60px;
    background-color: rgba(0,0,0,0);
    color: ${theme.colors.textOnSurface};
`;

export const InputPhone = styled(TextInput) <InputProps>`
    width: ${({ width }) => width ?? '100%'};
    height: 60px;
    background-color: rgba(0,0,0,0);
    color: ${theme.colors.textOnSurface};
`;

export const IconWrapper = styled(View).attrs((p: StyledIconWrapper) => p)`
    flex-grow: 1;
    height: 100%;
    align-items: center;
    justify-content: center;
    border-top-width: 5px;
    border-color: ${p => (p.active ? theme.colors.slider : 'transparent')};
    background-color: ${p =>
        p.active ? 'rgba(150, 150, 150, 0.3)' : 'transparent'};
`;

export const PanelTitle = styled(Title)`
    display: flex;
    font-size: 25px;
    margin: 0 auto;
`;

export const StyledIconButton = styled(IconButton).attrs(
    (p: StyledIconButtonProps) => {
        const { active } = p;
        return {
            ...p,
            color: active ? theme.colors.slider : theme.colors.black,
        };
    },
)`
    position: absolute;
    top: -5px;
  `;

export const StyledText = styled(Text)`
    color: ${theme.colors.white};
    top: 17px;
    width: 100%;
    text-align: center;
`;

export const TitleView = styled(View)``;

export const TitleWrapper = styled(View)`
    position: relative;
    align-items: center;
    justify-content: center;
    padding: 40px;
    width: 100%;
`;

export const ViewModal = styled.View`
    width: 35%;
    margin: 20px;
    background-color: white;
    border-radius: 5px;
    padding: 35px;
    align-items: center;
`;