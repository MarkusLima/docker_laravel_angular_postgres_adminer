import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ShowLog } from './index';

describe('Index', () => {
  let component: ShowLog;
  let fixture: ComponentFixture<ShowLog>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ShowLog],
    }).compileComponents();

    fixture = TestBed.createComponent(ShowLog);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
