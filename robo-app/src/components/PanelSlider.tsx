// Import de pacotes
import styled from "styled-components/native";
import { Dimensions } from "react-native";
import { Surface } from "react-native-paper";

// Import de páginas
import theme from "../global/styles/theme";

export const PanelSlider = styled(Surface)`
    flex-direction: column;
    margin-left: ${Dimensions.get('screen').width * 0.05}px;
    margin-right: ${Dimensions.get('screen').width * 0.05}px;
    border-top-right-radius: 30px;
    border-top-left-radius: 30px;
    position: relative;
    padding: 16px;
    padding-top: 20px;
    width: ${Dimensions.get('screen').width * 0.9}px;
    height: 100%;
    background-color: ${theme.colors.white};
`;