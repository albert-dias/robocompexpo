import styled from 'styled-components/native';
import { View } from 'react-native';
import { getStatusBarHeight } from 'react-native-iphone-x-helper';

interface ContainerProps {
    padding: number;
    vertical: boolean;
    horizontal: boolean;
    pb: boolean;
    pr: boolean;
    pt: boolean;
    pl: boolean;
}

const Container = styled(View).attrs((p: ContainerProps) => p)`
    padding-left: ${(p) => ((p.horizontal || p.pl) ? p.padding || 15 : 0)}px;
    padding-right: ${(p) => ((p.horizontal || p.pr) ? p.padding || 15 : 0)}px;
    padding-top: ${(p) => ((p.vertical || p.pt) ? p.padding || 15 : 0)}px;
    padding-bottom: ${(p) => ((p.vertical || p.pb) ? p.padding || 15 : 0)}px;
`;

export const Containerp = styled(View).attrs((p: ContainerProps) => p)`
    padding: ${(p) => p.padding || 0}px;  
`;

export const ContainerTop = styled(View).attrs((p: ContainerProps) => p)`
    padding: ${(p) => p.padding || 0}px;
    margin-top: ${getStatusBarHeight()}px;
    /* background: #FFFAF7;   */
`;

export default Container;