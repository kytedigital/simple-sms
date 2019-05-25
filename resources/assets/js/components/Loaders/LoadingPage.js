import React, { Component } from 'react';
import {
    AppProvider,
    Layout,
    Card,
    SkeletonPage,
    SkeletonBodyText,
    SkeletonDisplayText,
    TextContainer
} from '@shopify/polaris';

export default class LoadingPage extends Component {
    render() {
        return <AppProvider>
                <SkeletonPage fullWidth>
                    <Layout>
                        <Layout.Section secondary>
                            <Card>
                                <Card.Section>
                                    <TextContainer>
                                        <SkeletonDisplayText size="large" />
                                        <SkeletonBodyText lines={20} />
                                    </TextContainer>
                                </Card.Section>
                            </Card>
                            <Card subdued>
                                <Card.Section>
                                    <TextContainer>
                                        <SkeletonDisplayText size="small" />
                                        <SkeletonBodyText lines={2} />
                                    </TextContainer>
                                </Card.Section>
                            </Card>
                        </Layout.Section>
                        <Layout.Section>
                            <Card sectioned>
                                <SkeletonBodyText />
                            </Card>
                            <Card sectioned>
                                <TextContainer>
                                    <SkeletonDisplayText size="small" />
                                    <SkeletonBodyText />
                                </TextContainer>
                            </Card>
                        </Layout.Section>

                    </Layout>
                </SkeletonPage>
            </AppProvider>;
    }
}
