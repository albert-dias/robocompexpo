// Import de pacotes
import React, { useEffect } from 'react';
import { StyleSheet, TouchableHighlight, View } from 'react-native';
import { ActivityIndicator, IconButton, Text } from 'react-native-paper';
import { useStateLink } from '@hookstate/core';

// Import de páginas
import CardComponent, { CardLeft, CardContentList } from '../../components/Card';
import Container from '../../components/Container';
import theme from '../../global/styles/theme';
import GlobalContext from '../../context';
import { formatDate, convertFormatedToNormal } from '../../util/formatDate';
import { RootLoggedStackParamList } from '../LoggedStackNavigator';

const styles = StyleSheet.create({
    container: {
        flex: 1,
    },
    scrollView: {
        flexGrow: 1,
        backgroundColor: theme.colors.white,
        marginHorizontal: 0,
    },
    btn: {
        backgroundColor: theme.colors.surface,
        padding: 3,
        alignSelf: 'flex-end',
    },
    divwhite: {
        backgroundColor: theme.colors.white,
        width: '100%',
        height: 1,
        padding: 10,
    },
    limitContainer: {
        alignItems: 'flex-start',
        backgroundColor: theme.colors.white,
        alignSelf: 'flex-start',
    },
    sti: {
        backgroundColor: theme.colors.white,
        padding: 20,
    },
    div: {
        backgroundColor: '#C0C0C0',
        width: '80%',
        height: 1,
        alignSelf: 'center',
    },
    textStyle: {
        fontSize: 20,
        fontWeight: 'bold',
        color: 'black',
        alignSelf: 'center',
        padding: 6,
    },
    textStyleSub: {
        fontSize: 15,
        fontFamily: 'Manjari-Bold',
        color: 'black',
        padding: 6,
    },
    textStyleInfo: {
        fontSize: 15,
        color: 'black',
        padding: 5,
    },
    nview: {
        width: '100%',
        justifyContent: 'center',
        alignItems: 'center',
    },
    cardView: {
        justifyContent: 'center',
        alignItems: 'center',
    },
});

const {
    informations: {
        fetch, finalizedRef,
        loadingFinalizedRef
    },
} = GlobalContext;

interface ScheduledProps {
    navigate: (routeName: keyof RootLoggedStackParamList) => void;
}

const Finished: React.FC<ScheduledProps> = ({ navigate }) => {
    const canceled = useStateLink(finalizedRef);
    const loading = useStateLink(loadingFinalizedRef);

    useEffect(() => {
        fetch('finalized');
    }, []);

    if (loading.value || canceled.value === undefined) {
        return (
            <Container horizontal vertical padding={30}>
                <ActivityIndicator />
            </Container>
        );
    }

    return (
        <View style={styles.scrollView}>
            {canceled.value.map(i => (
                <Container key={i.id} horizontal vertical>
                    <CardComponent>
                        <CardLeft>
                            <IconButton icon="alarm-check" color={theme.colors.white} size={50} />
                        </CardLeft>
                        <CardContentList>
                            {/*
                  <Text style={styles.textStyle}>{i.category}</Text>
                  <View style={styles.div} />
                  */}
                            <Text style={styles.textStyleSub}>{i.comments}</Text>
                            <Text style={styles.textStyleSub}>
                                {formatDate(convertFormatedToNormal(i.created), 'FULL')}
                            </Text>
                            <Container
                                pt
                                padding={8}
                                pb
                                style={{
                                    flexDirection: 'row',
                                    justifyContent: 'space-between',
                                    alignItems: 'center',
                                }}>
                                <TouchableHighlight
                                    onPress={() => {
                                        console.log('navigate(CollectionDetails)');
                                    }}
                                    style={{
                                        flexGrow: 1,
                                    }}>
                                    <Text
                                        style={{
                                            flexGrow: 1,
                                            textAlign: 'center',
                                            fontSize: 18,
                                            fontFamily: 'Manjari-Bold',
                                            color: theme.colors.contrast,
                                        }}>
                                        Detalhes
                                    </Text>
                                </TouchableHighlight>
                            </Container>
                        </CardContentList>
                    </CardComponent>
                </Container>
            ))}
        </View>
    );
};

export default Finished;